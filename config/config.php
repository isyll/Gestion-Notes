<?php

$routes = [
    /* Web application routes */
    '/' => [
        'name' => 'list-niveaux',
        'handler' => 'NiveauxController@getNiveaux',
    ],
    'page404' => [
        'name' => 'page404',
        'handler' => 'HomeController@page404',
    ],
    '/app/login' => [
        'name' => 'login-page',
        'handler' => 'LoginController@connection',
    ],
    '/app/profile/{userId}' => [
        'name' => 'profile-page',
        'handler' => 'ProfileController@userPage',
    ],
    '/app/{niveauId}' => [
        'name' => 'list-classes',
        'handler' => 'ClassesController@getClasses',
    ],
    '/app/new-student' => [
        'name' => 'new-student',
        'handler' => 'StudentsController@newStudent',
    ],
    '/app/new-niveau' => [
        'name' => 'new-niveau',
        'handler' => 'NiveauxController@newNiveau',
    ],
    '/app/{niveauId}/{classeId}' => [
        'name' => 'list-students',
        'handler' => 'StudentsController@list',
    ],

    /* Routes POST */
    '/logout' => [
        'name' => 'logout',
        'handler' => 'LoginController@logout',
        'methods' => ['post']
    ],
    '/login' => [
        'name' => 'login',
        'handler' => 'LoginController@login',
        'methods' => ['post']
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
    '/create-niveau' => [
        'name' => 'create-niveau',
        'handler' => 'NiveauxController@createNiveau',
        'methods' => ['post']
    ],
    '/delete-niveau' => [
        'name' => 'delete-niveau',
        'handler' => 'NiveauxController@deleteNiveau',
        'methods' => ['post']
    ],
    '/create-classe' => [
        'name' => 'create-classe',
        'handler' => 'ClassesController@createClasse',
        'methods' => ['post']
    ],

    /* Routes d'administration */
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
