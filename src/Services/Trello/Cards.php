<?php

namespace AdrHumphreys\Workflow\Services\Trello;

class Cards
{
    private const CREATE_SINGULAR = '/1/cards';
    private const UPDATE_SINGULAR = '/1/cards/%s';

    public static function create(string $title, string $listId, ?string $editLink = null): string
    {
        $response = TrelloRequest::post(self::CREATE_SINGULAR, [
            'idList' => $listId,
            'name' => $title,
            'urlSource' => $editLink,
        ]);

        return $response['id'];
    }

    public static function setCardList(string $cardId, string $listId, ?string $editLink = null): void
    {
        TrelloRequest::put(sprintf(self::UPDATE_SINGULAR, $cardId), [
            'idList' => $listId,
            'urlSource' => $editLink,
        ]);
    }
}
