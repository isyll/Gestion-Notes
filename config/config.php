<?php

$routes = [
    /* Web application routes */
    '/' => [
        'name' => 'list-niveaux',
        'handler' => 'NiveauxController@getNiveaux',
        'title' => 'Niveaux'
    ],
    'page404' => [
        'name' => 'page404',
        'handler' => 'HomeController@page404',
        'title' => 'Page non trouvée'
    ],
    '/app/login' => [
        'name' => 'login-page',
        'handler' => 'LoginController@connection',
        'title' => 'Connexion'
    ],
    '/app/profile/{userId}' => [
        'name' => 'profile-page',
        'handler' => 'ProfileController@userPage',
        'title' => 'Profil'
    ],
    '/app/{niveauId}' => [
        'name' => 'list-classes',
        'handler' => 'ClassesController@getClasses',
        'title' => 'Classes'
    ],
    '/app/new-student' => [
        'name' => 'new-student',
        'handler' => 'StudentsController@newStudent',
        'title' => 'Créer élève'
    ],
    '/app/new-niveau' => [
        'name' => 'new-niveau',
        'handler' => 'NiveauxController@newNiveau',
        'title' => 'Créer un niveau'
    ],
    '/app/new-classe/{niveauId}' => [
        'name' => 'new-classe',
        'handler' => 'ClassesController@newClasse',
        'title' => 'Créer une classe'
    ],
    '/app/new-student/{niveauId}/{classeId}' => [
        'name' => 'new-student',
        'handler' => 'StudentsController@newStudent',
        'title' => 'Créer une élève'
    ],
    '/app/{niveauId}/{classeId}' => [
        'name' => 'list-students',
        'handler' => 'StudentsController@list',
        'title' => 'Elèves'
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
    '/delete-classe' => [
        'name' => 'delete-classe',
        'handler' => 'ClassesController@deleteClasse',
        'methods' => ['post']
    ],
    '/admin/create-user' => [
        'name' => 'create-user',
        'handler' => 'AdminController@createUser',
        'methods' => ['post']
    ],

    /* Routes d'administration */
    '/admin/new-user' => [
        'name' => 'create-user-page',
        'handler' => 'AdminController@newUser',
        'title' => 'Créer utilisateur'
    ],
    '/admin/user-admin' => [
        'name' => 'user-admin',
        'handler' => 'AdminController@userAdmin',
        'title' => 'Administration'
    ],

    /* JSON API routes */
    '/api/getclasses/{niveauId}' => [
        'name' => 'get-classe-by-niveau',
        'handler' => 'APIController@getClasses',
    ],
];
