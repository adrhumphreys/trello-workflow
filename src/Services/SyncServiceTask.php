<?php

namespace AdrHumphreys\Workflow\Services;

use AdrHumphreys\Workflow\Services\Trello\Trello;
use SilverStripe\Control\HTTPRequest;
use SilverStripe\Core\Environment;
use SilverStripe\Dev\BuildTask;

class SyncServiceTask extends BuildTask
{
    protected $title = 'Sync workflow services';

    /**
     * @param HTTPRequest|mixed $request
     */
    public function run($request): void
    {
        self::log('syncing states');
//        Trello::syncWorkflowStates();
        self::log('states synced');

        self::log('syncing cards');
        Trello::syncCards();
        self::log('cards synced');

        self::log('syncing labels');
//        Trello::syncLabels();
        self::log('cards synced');
    }

    public static function log(string $message): void
    {
        $endOfLine = Environment::isCli()
            ? PHP_EOL
            : '<br>';

        echo sprintf('%s %s', $message, $endOfLine);
    }
}
