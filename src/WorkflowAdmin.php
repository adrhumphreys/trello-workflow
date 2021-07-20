<?php

namespace AdrHumphreys\Workflow;

use SilverStripe\Admin\ModelAdmin;

class WorkflowAdmin extends ModelAdmin
{
    private static array $managed_models = [
        Workflow::class,
    ];

    private static string $url_segment = 'workflows';

    private static string $menu_title = 'Workflows';

    private static string $menu_icon_class = 'font-icon-flow-tree';
}
