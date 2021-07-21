<?php

namespace AdrHumphreys\Workflow;

use AdrHumphreys\Workflow\Services\Trello\Models\Card;
use AdrHumphreys\Workflow\WorkflowState;
use LogicException;
use SilverStripe\Control\Controller;
use SilverStripe\Control\HTTPRequest;

class WorkflowController extends Controller
{
    const ROUTE = 'trello-workflow';

    private static $url_segment = self::ROUTE;

    private static $url_handlers = [
        'POST /' => 'handleChange',
    ];

    private static $allowed_actions = [
        'handleChange',
    ];

    public function handleChange(HTTPRequest $request): string
    {
        $input = json_decode($request->getBody(), true);

        $proposedCard = $input['cardId'];
        $proposedState = $input['stepId'];

        foreach ([$proposedCard, $proposedState] as $inputCheck) {
            if (!$inputCheck || !is_numeric($inputCheck)) {
                throw new LogicException('Missing or invalid parameters');
            }
        }

        $card = Card::get()->byID($proposedCard);
        $state = WorkflowState::get()->filter([
            'ID' => $proposedState,
            'WorkflowID' => $card->State()->WorkflowID,
        ])->first();

        if (!$state) {
            throw new LogicException('Invalid workflow state');
        }

        $card->update(['StateID' => $state->ID])->write();

        return json_encode([
            'cardId' => $card->ID,
            'activeStep' => $state->ID,
        ]);
    }
}
