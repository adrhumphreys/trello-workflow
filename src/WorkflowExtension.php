<?php

namespace AdrHumphreys\Workflow;

use AdrHumphreys\Workflow\Actions\WorkflowWidget;
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
    }

    public function updateCMSActions(FieldList $fields): void
    {
        $workflowWidget = WorkflowWidget::create($this->owner);
        $fields->push($workflowWidget);
    }
}
