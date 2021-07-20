<?php

namespace AdrHumphreys\Workflow\Services;

use AdrHumphreys\Workflow\Workflow;

interface Service
{
    /*
     * Runs periodically to get the "columns" from the service and find or create
     * workflow states for each column. Allowing them to then show up for users to
     * select.
     */
    public function syncWorkflowStates(Workflow $workflow): void;
}
