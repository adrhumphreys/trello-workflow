<?php

namespace AdrHumphreys\Workflow\Services;

use AdrHumphreys\Workflow\Services\Trello\Boards;
use AdrHumphreys\Workflow\Services\Trello\Cards;
use AdrHumphreys\Workflow\Services\Trello\Trello;
use AdrHumphreys\Workflow\Workflow;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Dev\BuildTask;

class SyncServiceTask extends BuildTask
{
    protected $title = 'Sync workflow services';

    /**
     * @param HTTPRequest|mixed $request
     */
    public function run($request): void
    {
        // TODO: Support getting services per workflow
        $service = new Trello();
        // Uncomment to re-sync these
//        $service->syncBoards();

//        $workflows = Workflow::get();
//
//        foreach ($workflows as $workflow) {
//            $service->syncWorkflowStates($workflow);
//        }

        $r = Cards::create('Yikes', '60f63abffab0a284963727a1');
        echo '<pre>'; print_r($r); exit;
    }
}
