<?php

// require "./nexusRouter/src/NexusLoader.php";
require "./nexusRouter/vendor/autoload.php";

// NexusRouter\Router::get('/users' , 'Controllercillo/User');
new NexusRouter\NexusLoader(loadRoutesFile: true);


