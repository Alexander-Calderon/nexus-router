<?php

namespace NexusRouter;

require __DIR__ . "/helpers/helpers.php";
require getRouterPath() . "/config.php";
require getRouterPath() . "/core/router.php";


class NexusLoader
{
    public function __construct(bool $loadRoutesFile = true) {
        // NexusRouter\Router::init();

        if ( $loadRoutesFile ) {
            require getRouterPath() . "/routes.php";
        }
        Router::init();
    }
}