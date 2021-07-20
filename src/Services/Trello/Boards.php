<?php

namespace AdrHumphreys\Workflow\Services\Trello;

class Boards
{
    private const BOARDS = '/1/members/me/boards';
    private const COLUMNS = '/1/boards/%s/lists';

    public static function list(): array
    {
        return TrelloRequest::get(self::BOARDS, ['fields' => 'name,url,id']);
    }

    public static function columns(string $boardId): array
    {
        return TrelloRequest::get(sprintf(self::COLUMNS, $boardId));
    }
}
