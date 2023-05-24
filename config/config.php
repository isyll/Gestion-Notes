<?php

$routes = [
    '/' => [
        'name' => 'school-years',
        'handler' => 'SchoolYearsController@getYears',
    ],
    'page404' => [
        'name' => 'page404',
        'handler' => 'HomeController@page404',
    ],
    '/create-user' => [
        'name' => 'create-user',
        'handler' => 'AdminController@createUser',
    ],
    '/sc/{period}' => [
        'name' => '',
        'handler' => 'NiveauxController@getNiveaux',
    ],
    '/sc/{period}/{niveauSlug}' => [
        'name' => '',
        'handler' => 'ClassesController@getClasses',
    ],
    '/sc/{period}/{niveauSlug}/{classeSlug}' => [
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
    '/change-year-state' => [
        'name' => 'change-year-state',
        'handler' => 'SchoolYearsController@changeYearState',
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
    // 'db_name' => 'gnotes',
    // 'db_host' => 'locahost',
    // 'db_user' => 'isyll',
    // 'db_password' => 'xCplm_',
    // 'db_connection' => 'mysql',
    'accessDbName' => 'accesscontrol'
];
