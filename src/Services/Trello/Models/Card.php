<?php

namespace AdrHumphreys\Workflow\Services\Trello\Models;

use AdrHumphreys\Workflow\Services\Trello\Trello;
use AdrHumphreys\Workflow\WorkflowState;
use SilverStripe\ORM\DataObject;

/**
 * @property string Title
 * @property string TrelloId
 * @property string CardUrl
 * @property int StateID
 * @method WorkflowState State
 */
class Card extends DataObject
{
    private static string $singular_name = 'Card';

    private static string $plural_name = 'Cards';

    private static string $table_name = 'Trello_Card';

    private static array $db = [
        'Title' => 'Varchar(255)',
        'TrelloId' => 'Varchar(255)',
        'CardUrl' => 'Varchar(255)',
    ];

    private static array $has_one = [
        'State' => WorkflowState::class,
        'Owner' => DataObject::class,
    ];

    public function onAfterWrite(): void
    {
        $owner = $this->Owner();
        $workflowState = $this->State();

        foreach ([$owner, $workflowState] as $check){
            if (!($check && $check->exists())) {
                return;
            }
        }

        Trello::syncToState($owner, $workflowState);
    }
}
