<?php

namespace AdrHumphreys\Workflow\Actions;

use AdrHumphreys\Workflow\Workflow;
use AdrHumphreys\Workflow\WorkflowController;
use SilverStripe\Forms\FormField;

class WorkflowWidget extends FormField implements PretendFormAction
{
    private static $casting = [
        'getPropsJSON' => 'HTMLFragment',
    ];

    public function __construct($item)
    {
        parent::__construct('TrelloWorkflow', 'Workflow');
        $this->item = $item;
    }

    public function getPropsJSON() {
        $board = Workflow::get()->first();
        $states = $board ? $board->States() : [];
        $steps = [];

        foreach ($states as $state) {
            $steps[] = [
                'id' => $state->ID,
                'title' => $state->Title,
            ];
        }

        return json_encode([
            'states' => $steps,
            'cardId' => $this->item->CardID,
            'currentStateId' => $this->item->Card()->StateID,
            'workflowEndpoint' => WorkflowController::ROUTE,
            'noneSelected' => _t(self::class . '.NONE_SELECTED', 'No workflow selected'),
            'viewOnTrelloText' => _t(self::class . '.VIEW_ON_TRELLO', 'View card on Trello'),
        ]);
    }

    public function setUseButtonTag()
    {
        // no-op
    }
}
