<?php

namespace AdrHumphreys\Workflow;

use AdrHumphreys\Workflow\Services\Trello\Models\Board;
use AdrHumphreys\Workflow\Services\Trello\Trello;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\HasManyList;

/**
 * @property string Title
 * @property string TrelloToken
 * @property string TrelloKey
 * @property int BoardID
 * @method Board Board
 * @method WorkflowState[]|HasManyList States
 */
class Workflow extends DataObject
{
    private static string $singular_name = 'Workflow';

    private static string $plural_name = 'Workflows';

    private static string $table_name = 'Workflow_Workflow';

    private static array $db = [
        'Title' => 'Varchar(255)',
        'TrelloToken' => 'Varchar(255)',
        'TrelloKey' => 'Varchar(255)',
    ];

    private static array $has_one = [
        'Board' => Board::class,
    ];

    private static array $has_many = [
        'States' => WorkflowState::class,
    ];

    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        if (Board::get()->count() === 0) {
            $fields->removeByName('BoardID');
        }

        return $fields;
    }

    protected function onAfterWrite(): void
    {
        parent::onBeforeWrite();

        if (!$this->TrelloKey || !$this->TrelloToken) {
            return;
        }

        Trello::syncBoards($this->TrelloKey, $this->TrelloToken);
    }
}
