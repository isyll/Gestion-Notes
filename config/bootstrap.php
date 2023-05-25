<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once 'config.php';

use Core\Helpers;
use Core\Router;
use Core\SessionManager;
use Core\ErrorHandler;

// set_error_handler(function ($errno, $errstr, $errfile, $errline) {
//     ErrorHandler::logError($errno, $errstr, $errfile, $errline);
// });

$GLOBALS['viewsPath'] = dirname(__DIR__) . '/view';
$GLOBALS['siteName']  = "Breukh'S School";
$GLOBALS['baseURL']   = Helpers::getBaseURL();

SessionManager::start();

Router::$namespace = 'App\\Controller';
Router::loadConfig($routes);
Router::execute();
