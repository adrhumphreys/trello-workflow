<?php

namespace AdrHumphreys\Workflow\Services\Trello;

use SilverStripe\ORM\DataExtension;

class TrelloDataObjectExtension extends DataExtension
{
    private static array $db = [
        'CardId' => 'Varchar(255)',
    ];
}
