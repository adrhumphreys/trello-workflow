<?php

namespace AdrHumphreys\Workflow\Services\Trello\Models;

use SilverStripe\ORM\DataObject;

/**
 * @property string Title
 * @property string TrelloId
 * @property string InternalId
 */
class Label extends DataObject
{
    public const CMS_PAGE = [
        'id' => 'cms-page',
        'name' => 'CMS Page',
        'color' => 'blue',
    ];

    public const CMS_ELEMENT = [
        'id' => 'cms-element',
        'name' => 'CMS Block',
        'color' => 'sky',
    ];

    public const LABELS = [
        self::CMS_PAGE,
        self::CMS_ELEMENT,
    ];

    private static string $singular_name = 'Label';

    private static string $plural_name = 'Labels';

    private static string $table_name = 'Trello_Label';

    private static array $db = [
        'Title' => 'Varchar(255)',
        'TrelloId' => 'Varchar(255)',
        'InternalId' => 'Varchar(255)',
    ];
}
