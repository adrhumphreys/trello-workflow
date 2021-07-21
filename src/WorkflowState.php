<?php

namespace AdrHumphreys\Workflow;

use AdrHumphreys\Workflow\Services\Trello\Models\Board;
use AdrHumphreys\Workflow\Services\Trello\Models\Card;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;
use SilverStripe\ORM\HasManyList;

/**
 * Represents the state of a workflow applied to a data object
 * @property string Title
 * @property string TrelloId
 * @property int Sort
 * @property int WorkflowID
 * @property int BoardID
 * @method Workflow Workflow
 * @method Board Board
 * @method Card[]|HasManyList Cards
 */
class WorkflowState extends DataObject
{
    private static string $singular_name = 'Workflow state';

    private static string $plural_name = 'Workflow states';

    private static string $table_name = 'Workflow_State';

    private static array $db = [
        'Title' => 'Varchar(255)',
        'TrelloId' => 'Varchar(255)',
        'Sort' => 'Int',
    ];

    private static array $has_one = [
        'Workflow' => Workflow::class,
        'Board' => Board::class,
    ];

    private static array $has_many = [
        'Cards' => Card::class,
    ];

    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'WorkflowID',
        ]);

        return $fields;
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
