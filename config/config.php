<?php

$routes = [
    /* Web application routes */
    '/' => [
        'name' => 'niveaux',
        'handler' => 'NiveauxController@getNiveaux',
    ],
    'page404' => [
        'name' => 'page404',
        'handler' => 'HomeController@page404',
    ],
    '/app/{niveauId}' => [
        'name' => '',
        'handler' => 'ClassesController@getClasses',
    ],
    '/app/new-student' => [
        'name' => 'new-student',
        'handler' => 'StudentsController@newStudent',
    ],
    '/app/{niveauId}/{classeId}' => [
        'name' => '',
        'handler' => 'StudentsController@list',
    ],
    '/create-student' => [
        'name' => 'create-student',
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
    '/admin/create-user-page' => [
        'name' => 'create-user-page',
        'handler' => 'AdminController@newUser',
    ],
    '/admin/user-admin' => [
        'name' => 'user-admin',
        'handler' => 'AdminController@userAdmin',
    ],
    '/admin/create-user' => [
        'name' => 'create-user',
        'handler' => 'AdminController@createUser',
        'methods' => ['post']
    ],

    /* JSON API routes */
    '/api/getclasses/{niveauId}' => [
        'name' => 'get-classe-by-niveau',
        'handler' => 'APIController@getClasses',
    ],
];
