<?php

namespace AdrHumphreys\Workflow\Services\Trello;

use AdrHumphreys\Workflow\Services\Trello\Models\Board;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Forms\TextField;
use SilverStripe\ORM\DataExtension;

class TrelloWorkflowExtension extends DataExtension
{
    private static array $db = [
        'TrelloToken' => 'Varchar(255)',
        'TrelloKey' => 'Varchar(255)',
    ];

    private static array $has_one = [
        'TrelloBoard' => Board::class,
    ];

    public function updateCMSFields(FieldList $fields): void
    {
        $fields->removeByName([
            'TrelloToken',
            'TrelloKey',
            'TrelloBoardID',
        ]);

        if ($this->owner->Service !== Trello::class) {
            return;
        }

        $fields->addFieldsToTab('Root.Main', [
            TextField::create('TrelloToken', 'Token'),
            TextField::create('TrelloKey', 'Key'),
            DropdownField::create('TrelloBoardID', 'Board', Board::get())
                ->setDescription('You will need the sync to run for the boards to be listed'),
        ]);
    }
}
