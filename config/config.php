<?php

$routes = [
    '/' => [
        'name' => 'home',
        'handler' => 'SchoolYearsController@index',
    ],
    'page404' => [
        'name' => 'page404',
        'handler' => 'HomeController@page404',
    ],
    '/create-user' => [
        'name' => 'create-user',
        'handler' => 'AdminController@createUser',
    ],
    '/{period}' => [
        'name' => '',
        'handler' => 'NiveauxController@getNiveaux',
    ],
    '/{period}/{niveauSlug}' => [
        'name' => '',
        'handler' => 'ClassesController@getClasses',
    ],
    '/{period}/{niveauSlug}/{classeSlug}' => [
        'name' => '',
        'handler' => 'StudentsController@studentsList',
    ],
    '/create-student' => [
        'name' => 'create-year',
        'handler' => 'StudentsController@createStudent',
        'methods' => ['post']
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
    '/update-year' => [
        'name' => 'update-year',
        'handler' => 'SchoolYearsController@updateYear',
        'methods' => ['post']
    ],
    '/active-year' => [
        'name' => 'active-year',
        'handler' => 'SchoolYearsController@activeYear',
        'methods' => ['post']
    ],
    '/create-niveau' => [
        'name' => 'create-niveau',
        'handler' => 'NiveauxController@createNiveau',
        'methods' => ['post']
    ],
    '/create-classe' => [
        'name' => 'create-classe',
        'handler' => 'ClassesController@createClasse',
        'methods' => ['post']
    ],
    '/login' => [
        'name' => 'login',
        'handler' => 'LoginController@connect',
        'methods' => ['post']
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
