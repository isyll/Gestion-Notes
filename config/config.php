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
    '/connexion' => [
        'name' => 'login-page',
        'handler' => 'LoginController@connection',
        'title' => 'Connexion'
    ],
    '/disciplines' => [
        'name' => 'subjects',
        'handler' => 'SubjectsController@page',
        'title' => 'Disciplines'
    ],
    '/niveau/{niveauId}' => [
        'name' => 'list-classes',
        'handler' => 'ClassesController@getClasses',
        'title' => 'Classes'
    ],
    '/annees' => [
        'name' => 'school-years',
        'handler' => 'SchoolYearsController@list',
        'title' => 'Années scolaires'
    ],
    '/nouveau-eleve/{niveauId}/{classeId}' => [
        'name' => 'new-student',
        'handler' => 'StudentsController@newStudent',
        'title' => 'Créer une élève'
    ],
    '/eleves/{niveauId}/{classeId}' => [
        'name' => 'list-students',
        'handler' => 'StudentsController@list',
        'title' => 'Elèves'
    ],
    '/eleve-page/{niveauId}/{classeId}/{studentId}' => [
        'name' => 'student-page',
        'handler' => 'StudentsController@studentPage',
        'title' => 'Page élève'
    ],
    '/modifier-eleve/{niveauId}/{classeId}/{studentId}' => [
        'name' => 'edit-student-page',
        'handler' => 'StudentsController@editStudent',
        'title' => 'Modifier élève'
    ],

    /* Routes POST */
    '/logout' => [
        'name' => 'logout',
        'handler' => 'LoginController@logout',
        'methods' => ['post']
    ],
    '/log-user' => [
        'name' => 'login',
        'handler' => 'LoginController@login',
        'methods' => ['post']
    ],
    '/create-student' => [
        'name' => 'create-student',
        'handler' => 'StudentsController@createStudent',
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
    '/edit-niveau' => [
        'name' => 'edit-niveau',
        'handler' => 'NiveauxController@edit',
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
    '/edit-classe' => [
        'name' => 'edit-classe',
        'handler' => 'ClassesController@edit',
        'methods' => ['post']
    ],
    '/admin/create-user' => [
        'name' => 'create-user',
        'handler' => 'AdminController@createUser',
        'methods' => ['post']
    ],
    '/delete-student' => [
        'name' => 'delete-student',
        'handler' => 'StudentsController@delete',
        'methods' => ['post']
    ],
    '/edit-student' => [
        'name' => 'edit-student',
        'handler' => 'StudentsController@edit',
        'methods' => ['post']
    ],
    '/create-year' => [
        'name' => 'create-year',
        'handler' => 'SchoolYearsController@createYear',
        'methods' => ['post']
    ],
    '/edit-year' => [
        'name' => 'edit-year',
        'handler' => 'SchoolYearsController@edit',
        'methods' => ['post']
    ],
    '/delete-year' => [
        'name' => 'delete-year',
        'handler' => 'SchoolYearsController@deleteYear',
        'methods' => ['post']
    ],
    '/create-subject-group' => [
        'name' => 'create-subject-group',
        'handler' => 'SubjectsController@createGroup',
        'methods' => ['post']
    ],

    /* Routes d'administration */
    '/admin/profile/{userId}' => [
        'name' => 'profile-page',
        'handler' => 'ProfileController@userPage',
        'title' => 'Profil'
    ],
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
    '/api/getniveaux' => [
        'name' => 'get-all-niveaux',
        'handler' => 'APIController@getNiveaux',
    ],
    '/api/getclasses/{niveauId}' => [
        'name' => 'get-classes-by-niveau',
        'handler' => 'APIController@getClassesByNiveauId',
    ],
];
