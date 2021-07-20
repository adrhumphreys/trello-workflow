<?php

namespace AdrHumphreys\Workflow\Services\Trello;

use AdrHumphreys\Workflow\Services\Trello\Models\Board;
use AdrHumphreys\Workflow\WorkflowState;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class TrelloWorkflowStateExtension extends DataExtension
{
    private static array $db = [
        'TrelloName' => 'Varchar(255)',
        'TrelloId' => 'Varchar(255)',
        'TrelloPos' => 'Int',
    ];

    private static array $has_one = [
        'TrelloBoard' => Board::class,
    ];

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->removeByName([
            'TrelloId',
            'TrelloPos',
            'TrelloBoardID',
        ]);

        $fields->makeFieldReadonly('TrelloName');
    }

    public static function findOrCreate(string $id): WorkflowState
    {
        $workflowState = WorkflowState::get()->find('TrelloId', $id);

        if (!$workflowState) {
            $workflowState = WorkflowState::create();
        }

        return $workflowState;
    }
}
