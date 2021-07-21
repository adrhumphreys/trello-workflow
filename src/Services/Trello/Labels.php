<?php

namespace AdrHumphreys\Workflow\Services\Trello;

class Labels
{
    private const LABELS = '/1/labels';

    public static function create(string $title, string $color, string $boardId): array
    {
        return TrelloRequest::post(self::LABELS, [
            'name' => $title,
            'color' => $color,
            'idBoard' => $boardId,
        ]);
    }
}
