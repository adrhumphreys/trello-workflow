<?php

namespace AdrHumphreys\Workflow\Services\Trello;

use AdrHumphreys\Workflow\Services\Service;
use AdrHumphreys\Workflow\Services\Trello\Models\Board;
use AdrHumphreys\Workflow\Workflow;
use AdrHumphreys\Workflow\WorkflowState;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Core\Injector\Injectable;
use SilverStripe\ORM\DataObject;

class Trello implements Service
{
    use Injectable;

    public function syncWorkflowStates(Workflow $workflow): void
    {
        $boardId = $workflow->TrelloBoard()->BoardId;
        $columns = Boards::columns($boardId);

        foreach ($columns as $column) {
            $state = TrelloWorkflowStateExtension::findOrCreate($column['id']);
            $state->TrelloId = $column['id'];
            $state->Title = $column['name'];
            $state->TrelloName = $column['name'];
            $state->TrelloPos = $column['pos'];
            $state->WorkflowID = $workflow->ID;

            $board = Board::get()->find('BoardId', $column['idBoard']);

            if ($board) {
                $state->TrelloBoardID = $board->ID;
            }

            $state->write();
        }
    }

    // TODO: Associate the boards with a workflow rather than all workflow
    public function syncBoards(): void
    {
        $boards = Boards::list();

        foreach ($boards as $board) {
            $boardDo = Board::findOrCreate($board['id']);
            $boardDo->Title = $board['name'];
            $boardDo->BoardId = $board['id'];
            $boardDo->BoardUrl = $board['url'];
            $boardDo->write();
        }
    }

    public function syncToState(DataObject $item, WorkflowState $state): void
    {
        $editLink = null;

        if ($item instanceof SiteTree) {
            $editLink = $item->CMSEditLink();
        }

        // Create a new card other wise we move it
        if (!$item->CardId) {
            $item->CardId = Cards::create($item->Title, $state->TrelloId, $editLink);
            return;
        }

        Cards::setCardList($item->CardId, $state->TrelloId, $editLink);
    }
}
