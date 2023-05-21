<?php

$routes = [
    '/' => [
        'name' => 'home',
        'handler' => 'AdminController@schoolYears',
    ],
    'page404' => [
        'name' => 'page404',
        'handler' => 'HomeController@page404',
    ],
    '/students' => [
        'name' => 'students',
        'handler' => 'AdminController@students',
    ],
    '/login' => [
        'name' => 'login',
        'handler' => 'LoginController@connect',
    ],
    '/create-user' => [
        'name' => 'create-user',
        'handler' => 'AdminController@createUser',
    ],
    '/niveaux' => [
        'name' => 'niveaux',
        'handler' => 'AdminController@niveaux',
    ],
    '/classes' => [
        'name' => 'classes',
        'handler' => 'AdminController@classes',
    ],
    '/school-years/{period}' => [
        'name' => 'classes',
        'handler' => 'AdminController@schoolYears',
    ],
    '/school-years' => [
        'name' => 'classes',
        'handler' => 'AdminController@schoolYears',
    ],
];

$config = [
    'db_name' => 'gnotes',
    'db_host' => 'locahost',
    'db_user' => 'isyll',
    'db_password' => 'xCplm_',
    'db_connection' => 'mysql',
    'accessDbName' => 'accesscontrol'
];
