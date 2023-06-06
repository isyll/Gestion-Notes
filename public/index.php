<?php

ini_set('memory_limit', '-1');

require_once dirname(__DIR__) . '/vendor/autoload.php';

$routes = require_once dirname(__DIR__) . '/config/routes.php';

$GLOBALS['viewsPath'] = dirname(__DIR__) . '/view';
$GLOBALS['siteName']  = "Breukh'S School";

\Core\SessionManager::start();

\Core\Router::$namespace = 'App\\Controller';
\Core\Router::loadConfig($routes);
\Core\Router::execute();
