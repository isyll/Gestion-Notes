<?php

use Core\Controller;
use Core\Database;
use Core\Router;
use Core\ErrorHandler;

$GLOBALS['viewsPath'] = dirname(__DIR__) . '/view';
$GLOBALS['siteName'] = "Breukh School";
$GLOBALS['baseURL'] = Controller::getBaseURL();

$db     = new Database(dbname: 'gnotes', user: 'isyll', password: 'xCplm_');
$router = new Router(ns: 'App\Controller', db: $db);
$router->register(name: 'home', path: '/', handler: ['HomeController', 'index']);
$router->register(name: 'students', handler: ['AdminController', 'students']);
$router->register(name: 'niveaux', handler: ['AdminController', 'niveaux']);
$router->register(name: 'classes', handler: ['AdminController', 'classes']);
$router->add404(['Page404Controller', 'index']);
$router->execute();

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
  ErrorHandler::logError($errno, $errstr, $errfile, $errline);
});