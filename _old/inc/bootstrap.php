<?php

$basePath = dirname(__DIR__);

// Classes
require "$basePath/vendor/autoload.php";


// Helpers
foreach (glob("$basePath/helpers/*.php") as $helper) {
    require_once $helper;
}

// Config
$config = require "$basePath/config.php";
