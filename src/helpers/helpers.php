<?php


// get current file path
function getRouterPath(){
    return dirname(__DIR__ , 1);
}

// get index path
function getBasePath(){
    return dirname($_SERVER["SCRIPT_FILENAME"]);
}




