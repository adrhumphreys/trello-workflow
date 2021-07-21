<?php

namespace AdrHumphreys\Workflow\Services\Trello;

use AdrHumphreys\Workflow\Services\Trello\Models\Board;
use AdrHumphreys\Workflow\Services\Trello\Models\Card;
use AdrHumphreys\Workflow\Workflow;
use AdrHumphreys\Workflow\WorkflowExtension;
use AdrHumphreys\Workflow\WorkflowState;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\ValidationException;

class Trello
{
    public static function syncBoards(string $key, string $token): void
    {
        $boards = Boards::list($key, $token);

        foreach ($boards as $board) {
            $boardDo = Board::findOrCreate($board['id']);
            $boardDo->Title = $board['name'];
            $boardDo->BoardId = $board['id'];
            $boardDo->BoardUrl = $board['url'];
            $boardDo->write();
        }
    }

    public static function syncWorkflowStates(): void
    {
        $workflow = Workflow::get()->first();

        if (!$workflow) {
            return;
        }

        $boardId = $workflow->Board()->BoardId;
        $columns = Boards::columns($boardId);

        foreach ($columns as $column) {
            $state = WorkflowState::findOrCreate($column['id']);
            $state->TrelloId = $column['id'];
            $state->Title = $column['name'];
            $state->Sort = $column['pos'];
            $state->WorkflowID = $workflow->ID;

            $board = Board::get()->find('BoardId', $column['idBoard']);

            if ($board) {
                $state->BoardID = $board->ID;
            }

            $state->write();
        }
    }

    public static function syncCards(): void
    {
        $cards = Card::get();

        $states = WorkflowState::get()
            ->map('TrelloId', 'ID')
            ->toArray();

        /** @var Card $card */
        foreach ($cards as $card) {
            $trelloVersion = Cards::getId($card->TrelloId);

            // Check if the card is archived
            if ($trelloVersion['closed'] ?? false === true) {
                $card->delete();
                continue;
            }

            if (!array_key_exists('idList', $trelloVersion)) {
                continue;
            }

            $stateId = $states[$trelloVersion['idList']] ?? null;

            if ($stateId === $card->StateID) {
                continue;
            }

            // If no valid state then the card has been removed
            if (!$stateId) {
                $card->delete();
                continue;
            }

            $card->StateID = $stateId;
            $card->write();
        }
    }

    /**
     * This makes the assumption the preoprty will be set on the object
     *
     * @param DataObject|WorkflowExtension $item
     * @param WorkflowState $state
     * @throws ValidationException
     */
    public static function syncToState(DataObject $item, WorkflowState $state): void
    {
        $editLink = null;

        if ($item instanceof SiteTree || $item instanceof BaseElement) {
            $editLink = $item->CMSEditLink();
        }

        // Create a new card other wise we move it
        if (!$item->CardID || !$item->Card()->exists()) {
            $card = Cards::create($item->Title, $state, $editLink);

            if (!$card) {
                return;
            }

            $item->CardID = $card->ID;
            return;
        }

        Cards::updateCard($item->Card(), $state, $editLink);
    }
}
