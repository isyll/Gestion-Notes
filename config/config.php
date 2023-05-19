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
Router::add404(['Page404Controller', 'index']);
Router::register(name: 'home', path: '/', handler: ['HomeController', 'index']);
Router::register(name: 'students', handler: ['AdminController', 'students']);
Router::register(name: 'login', handler: ['LoginController', 'connect'], methods: ['POST']);
Router::register(name: 'niveaux', handler: ['AdminController', 'niveaux']);
Router::register(name: 'classes', handler: ['AdminController', 'classes']);
Router::execute();

AccessControl::loadFromDatabase($db, 'accesscontrol');
$GLOBALS['access'] = AccessControl::getDatas();

set_error_handler(function ($errno, $errstr, $errfile, $errline) {
  ErrorHandler::logError($errno, $errstr, $errfile, $errline);
});