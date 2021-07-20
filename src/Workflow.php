<?php

namespace AdrHumphreys\Workflow;

use AdrHumphreys\Workflow\Services\Trello\Trello;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataObject;

class Workflow extends DataObject
{
    private static string $singular_name = 'Workflow';

    private static string $plural_name = 'Workflows';

    private static string $table_name = 'Workflow_Workflow';

    private static array $db = [
        'Title' => 'Varchar(255)',
        // This is the service that's selected, allowing us to in the future have multiple
        // services associated with the CMS. E.g. we might use Trello or JIRA
        'Service' => 'Varchar(255)',
        // The type of model to apply the workflow to
        'Type' => 'Varchar(255)',
    ];

    private static array $has_many = [
        'States' => WorkflowState::class,
    ];

    public function getCMSFields(): FieldList
    {
        $fields = parent::getCMSFields();
        $fields->removeByName([
            'Service',
        ]);

        $fields->addFieldsToTab('Root.Main', [
            DropdownField::create('Service', 'Service', $this->getServices()),
            DropdownField::create('Type', 'Type', $this->getTypes()),
        ]);

        return $fields;
    }

    /*
     * TODO: Implement a "gathering" mechanism for implementations of Service
     */
    public function getServices(): array
    {
        return [
            Trello::class => 'Trello',
        ];
    }

    /*
     * TODO: Implement a "gathering" mechanism for types to apply (perhaps config)
     */
    public function getTypes(): array
    {
        return [
            SiteTree::class => 'Pages',
            BaseElement::class => 'Blocks (elements)',
        ];
    }
}
