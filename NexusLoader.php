<?php
require __DIR__ . "/helpers/helpers.php";
require getRouterPath() . "/config.php";
require getRouterPath() . "/core/router.php";
require getRouterPath() . "/routes.php";
NexusRouter\Router::init();