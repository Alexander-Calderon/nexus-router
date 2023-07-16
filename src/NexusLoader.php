<?php

namespace NexusRouter;

require __DIR__ . "/helpers/helpers.php";
require getRouterPath() . "/config.php";
require getRouterPath() . "/core/router.php";

use NexusRouter\Core\Router;

class NexusLoader
{
    public function __construct() {
        // NexusRouter\Router::init();

        if ( Config::ENABLE_ROUTES_FILE ) {
            require getRouterPath() . "/routes.php";
        }
        Router::init();
    }
}