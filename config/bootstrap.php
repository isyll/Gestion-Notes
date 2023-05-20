<?php

require_once dirname(__DIR__) . '/vendor/autoload.php';

require_once 'config.php';

use Core\SessionManager;
use Core\Database;
use Core\AccessControl;
use Core\Helpers;
use Core\Router;
use Core\ErrorHandler;

SessionManager::start();

// set_error_handler(function ($errno, $errstr, $errfile, $errline) {
//     ErrorHandler::logError($errno, $errstr, $errfile, $errline);
// });

$db = new Database(dbname: $config['db_name'], user: $config['db_user'], password: $config['db_password']);
AccessControl::loadFromDatabase($db, $config['accessDbName']);

$GLOBALS['access']    = AccessControl::getDatas();
$GLOBALS['viewsPath'] = dirname(__DIR__) . '/view';
$GLOBALS['siteName']  = "Breukh School";
$GLOBALS['baseURL']   = Helpers::getBaseURL();

Router::$db        = $db;
Router::$namespace = 'App\\Controller';
Router::loadConfig($routes);
Router::execute();
