<?php
define('DS', DIRECTORY_SEPARATOR);
//Updated with index.php in public folder
define('ROOT', __DIR__ . DS . '../app' . DS);
$config = include_once ROOT . 'config/config.php';
require_once ROOT . './../vendor/autoload.php';
require_once ROOT . 'config/services.php';
\Ubiquity\controllers\Startup::run($config);

