<?php

namespace AdrHumphreys\Workflow\Services\Trello;

class Boards
{
    private const BOARDS = '/1/members/me/boards';
    private const COLUMNS = '/1/boards/%s/lists';

    /*
     * When this gets called for a the first time there is no saved state for the
     * key/token so we need to pass it to the request
     */
    public static function list(string $key, string $token): array
    {
        return TrelloRequest::get(self::BOARDS, [
            'fields' => 'name,url,id',
            'key' => $key,
            'token' => $token,
        ]);
    }

    public static function columns(string $boardId): array
    {
        return TrelloRequest::get(sprintf(self::COLUMNS, $boardId));
    }
}
