<?php

namespace AdrHumphreys\Workflow;

use AdrHumphreys\Workflow\Services\Trello\Models\Card;
use AdrHumphreys\Workflow\Services\Trello\Trello;
use DNADesign\Elemental\Models\BaseElement;
use SilverStripe\CMS\Model\SiteTree;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;

/**
 * @property SiteTree|BaseElement|$this owner
 * @property string CardID
 * @method Card Card
 */
class WorkflowExtension extends DataExtension
{
    private static array $has_one = [
        'Card' => Card::class,
    ];

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->removeByName('CardID');

        $workflow = Workflow::get()->first();

        if (!$workflow) {
            return;
        }

        $currentStateId = $this->owner->CardID && $this->owner->Card()->exists()
            ? $this->owner->Card()->StateID
            : 0;

        $fields->addFieldsToTab('Root.Main', [
            DropdownField::create(
                'WorkflowStateID',
                'State',
                $workflow->States(),
                $currentStateId
            )
                ->setEmptyString('No workflow'),
        ]);
    }

    public function onBeforeWrite(): void
    {
        $owner = $this->owner;

        if (!$owner->isInDB() || !$owner->WorkflowStateID) {
            return;
        }

        $workflowState = WorkflowState::get_by_id($owner->WorkflowStateID);

        if (!$workflowState) {
            return;
        }

        Trello::syncToState($owner, $workflowState);
    }
}
