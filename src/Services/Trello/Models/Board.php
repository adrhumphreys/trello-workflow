<?php

namespace AdrHumphreys\Workflow\Services\Trello\Models;

use AdrHumphreys\Workflow\Workflow;
use SilverStripe\ORM\DataObject;

/**
 * @property string Title
 * @property string BoardId
 * @property string BoardUrl
 * @property int WorkflowID
 * @method Workflow Workflow
 */
class Board extends DataObject
{
    private static string $singular_name = 'Board';

    private static string $plural_name = 'Boards';

    private static string $table_name = 'Trello_Board';

    private static array $db = [
        'Title' => 'Varchar(255)',
        'BoardId' => 'Varchar(255)',
        'BoardUrl' => 'Varchar(255)',
    ];

    private static array $has_one = [
        'Workflow' => Workflow::class,
    ];

    public static function findOrCreate(string $boardId): Board
    {
        $board = static::get()->find('BoardId', $boardId);

        if (!$board) {
            $board = Board::create();
        }

        return $board;
    }
}
