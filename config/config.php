<?php

$routes = [
    '/' => [
        'name' => 'home',
        'handler' => 'HomeController@index',
    ],
    'page404' => [
        'name' => 'page404',
        'handler' => 'HomeController@page404',
    ],
    // '/students' => [
    //     'name' => 'students',
    //     'handler' => 'AdminController@students',
    // ],
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
        'handler' => 'NiveauxController@index',
    ],
    '/niveaux/{niveau}' => [
        'name' => 'classes-',
        'handler' => 'ClassesController@index',
    ],
    '/classes' => [
        'name' => 'classes',
        'handler' => 'ClassesController@index',
    ],
    '/school-years' => [
        'name' => 'school-years',
        'handler' => 'SchoolYearsController@index',
    ],
    '/school-years/{period}' => [
        'name' => 'schoolYears-',
        'handler' => 'SchoolYearsController@index',
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
