<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once 'config.php';

use Core\Helpers;
use Core\Router;
use Core\ErrorHandler;

// set_error_handler(function ($errno, $errstr, $errfile, $errline) {
//     ErrorHandler::logError($errno, $errstr, $errfile, $errline);
// });

$GLOBALS['viewsPath'] = dirname(__DIR__) . '/view';
$GLOBALS['siteName']  = "Breukh'S School";
$GLOBALS['baseURL']   = Helpers::getBaseURL();

Router::$namespace = 'App\\Controller';
Router::$base      = 'sc';
Router::loadConfig($routes);
Router::execute();
