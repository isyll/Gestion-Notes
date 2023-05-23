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
        'name' => '',
        'handler' => 'ClassesController@index',
    ],
    '/classes' => [
        'name' => 'classes',
        'handler' => 'ClassesController@index',
    ],
    '/classes/{id}' => [
        'name' => 'students',
        'handler' => 'StudentsController@index',
    ],
    '/school-years' => [
        'name' => 'school-years',
        'handler' => 'SchoolYearsController@index',
    ],
    '/create-year' => [
        'name' => 'create-year',
        'handler' => 'SchoolYearsController@createYear',
        'methods' => ['post']
    ],
    '/remove-year' => [
        'name' => 'remove-year',
        'handler' => 'SchoolYearsController@removeYear',
        'methods' => ['post']
    ],
    '/school-years/{period}' => [
        'name' => '',
        'handler' => 'NiveauxController@index',
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
