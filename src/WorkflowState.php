<?php

namespace AdrHumphreys\Workflow;

use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;

/*
 * Represents the state of a workflow applied to a data object
 */
class WorkflowState extends DataObject
{
    private static string $singular_name = 'Workflow state';

    private static string $plural_name = 'Workflow states';

    private static string $table_name = 'Workflow_State';

    private static array $db = [
        'Title' => 'Varchar(255)',
    ];

    private static array $has_one = [
        'Workflow' => Workflow::class,
    ];

    private static array $has_many = [
        'Objects' => DataObject::class,
    ];

    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();

        $fields->removeByName([
            'WorkflowID',
        ]);

        return $fields;
    }
}
