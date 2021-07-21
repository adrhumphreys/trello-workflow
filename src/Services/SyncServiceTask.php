<?php

namespace AdrHumphreys\Workflow\Services;

use AdrHumphreys\Workflow\Services\Trello\Trello;
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
        echo 'syncing states <br>';
        echo PHP_EOL;
//        Trello::syncWorkflowStates();
        echo 'states synced <br>';
        echo PHP_EOL;
        echo 'syncing cards <br>';
        echo PHP_EOL;
        Trello::syncCards();
        echo 'cards synced <br>';
        echo PHP_EOL;
    }
}
