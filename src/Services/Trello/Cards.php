<?php

namespace AdrHumphreys\Workflow\Services\Trello;

use AdrHumphreys\Workflow\Services\Trello\Models\Card;
use AdrHumphreys\Workflow\WorkflowState;

class Cards
{
    private const GET_SINGULAR = '/1/cards/%s';
    private const CREATE_SINGULAR = '/1/cards';
    private const UPDATE_SINGULAR = '/1/cards/%s';

    public static function getId(string $id): ?array
    {
        return TrelloRequest::get(sprintf(self::GET_SINGULAR, $id), [
            'fields' => 'idList,closed'
        ]);
    }

    public static function create(
        string $title,
        WorkflowState $state,
        ?string $editLink = null,
        ?string $labelId = null
    ): ?Card {
        $response = TrelloRequest::post(self::CREATE_SINGULAR, [
            'idList' => $state->TrelloId,
            'name' => $title,
            'urlSource' => $editLink,
            'idLabels' => $labelId,
        ]);

        if (!$response || !array_key_exists('id', $response)) {
            return null;
        }

        $card = Card::create();
        $card->Title = $title;
        $card->StateID = $state->ID;
        $card->TrelloId = $response['id'];
        $card->CardUrl = $response['url'];
        $card->write();

        return $card;
    }

    public static function updateCard(Card $card, WorkflowState $state, ?string $editLink = null): void
    {
        TrelloRequest::put(sprintf(self::UPDATE_SINGULAR, $card->TrelloId), [
            'idList' => $state->TrelloId,
            'urlSource' => $editLink,
        ]);

        $card->StateID = $state->ID;
        $card->write();
    }
}
