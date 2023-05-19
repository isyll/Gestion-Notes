<?php

use Core\AccessControl;
use Core\Controller;
use Core\Database;
use Core\Router;
use Core\ErrorHandler;

$GLOBALS['viewsPath'] = dirname(__DIR__) . '/view';
$GLOBALS['siteName']  = "Breukh School";
$GLOBALS['baseURL']   = Controller::getBaseURL();

$db = new Database(dbname: 'gnotes', user: 'isyll', password: 'xCplm_');

Router::$db        = $db;
Router::$namespace = 'App\\Controller';
Router::register(name: 'home', path: '/', handler: ['HomeController', 'index']);
Router::register(name: 'students', handler: ['AdminController', 'students']);
Router::register(name: 'niveaux', handler: ['AdminController', 'niveaux']);
Router::register(name: 'classes', handler: ['AdminController', 'classes']);
Router::add404(['Page404Controller', 'index']);
Router::execute();

$acdbTable = 'accesscontrol';
AccessControl::loadFromDatabase($db, $acdbTable);
$GLOBALS['access'] = AccessControl::getDatas();

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
  ErrorHandler::logError($errno, $errstr, $errfile, $errline);
});