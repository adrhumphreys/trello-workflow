<?php

namespace AdrHumphreys\Workflow;

use AdrHumphreys\Workflow\Services\Trello\Trello;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

class WorkflowExtension extends DataExtension
{
    private static array $has_one = [
        'WorkflowState' => WorkflowState::class,
    ];

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->removeByName('WorkflowStateID');

        if ($this->owner instanceof SiteTree) {
            $siteTreeWorkflow = Workflow::get()->find('Type', SiteTree::class);

            if ($siteTreeWorkflow) {
                $fields->addFieldsToTab('Root.Main', [
                    DropdownField::create('WorkflowStateID', 'State', $siteTreeWorkflow->States())
                        ->setEmptyString('No workflow'),
                ]);
            }
        }
    }

    public function onBeforeWrite(): void
    {
        $owner = $this->owner;

        if (!$owner->isInDB() || !$owner->WorkflowStateID || !$owner->WorkflowState->exists()) {
            return;
        }

        Trello::create()->syncToState($owner, $owner->WorkflowState());
    }
}
