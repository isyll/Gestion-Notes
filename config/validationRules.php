<?php

return [
    'create-student' => [
        [
            'name' => 'firstname',
            'rules' => [
                'required',
                'min_length' => [
                    'value' => 1,
                    'error_msg' => 'Le prénom est trop court'
                ],
                'max_length' => [
                    'value' => 100,
                    'error_msg' => 'Le prénom est trop long'
                ],
                'error_msg' => 'Le prénom est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'lastname',
            'rules' => [
                'required',
                'min_length' => [
                    'value' => 1,
                    'error_msg' => 'Le nom que vous avez saisi est trop court'
                ],
                'max_length' => [
                    'value' => 100,
                    'error_msg' => 'Le nom que vous avez saisi est trop long'
                ],
                'error_msg' => 'Le nom est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'gender',
            'rules' => [
                'required',
                'error_msg' => 'Le sexe est manquant',
                'type' => [
                    'value' => 'set',
                    'error_msg' => 'Le sexe ne répond pas aux citères',
                    'set_values' => ['homme', 'femme']
                ],
            ],
            'process' => ['del_multiple_spaces', 'to_lower_case']
        ],
        [
            'name' => 'email',
            'rules' => [
                'min_length' => [
                    'value' => 5,
                    'error_msg' => 'L\'adresse email est trop courte'
                ],
                'max_length' => [
                    'value' => 255,
                    'error_msg' => 'L\'addresse est trop longue'
                ],
                'error_msg' => 'L\'adresse email est requis'
            ],
            'process' => ['del_multiple_spaces', 'to_lower_case']
        ],
        [
            'name' => 'studentType',
            'rules' => [
                'required',
                'type' => [
                    'value' => 'set',
                    'error_msg' => 'Le type ne répond pas aux citères',
                    'set_values' => ['externe', 'interne']
                ],
                'error_msg' => 'Le type est requis'
            ],
            'process' => ['del_all_spaces', 'to_lower_case']

        ],
        [
            'name' => 'birthdate',
            'rules' => [
                'type' => [
                    'value' => 'date',
                    'error_msg' => 'La date de naissance ne est invalide',
                ],
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'niveauId',
            'rules' => [
                'required',
                'type' => [
                    'value' => 'number',
                    'error_msg' => 'Le niveau choisi est invalide'
                ],
                'error_msg' => 'Le niveau est requis'
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'classeId',
            'rules' => [
                'required',
                'type' => [
                    'value' => 'number',
                    'error_msg' => 'La classe choisie est invalide'
                ],
                'error_msg' => 'La classe est requis'
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'phone',
            'rules' => [
                'type' => [
                    'value' => 'phone',
                    'error_msg' => 'Le numéro de téléphone saisi est invalide'
                ],
                'error_msg' => 'Le numéro saisi est requis'
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'address',
            'rules' => [],
            'process' => ['del_multiple_spaces']
        ],
    ],

    'edit-niveau' => [
        [
            'name' => 'niveauId',
            'rules' => [
                'required',
                'type' => [
                    'value' => 'number',
                    'error_msg' => 'Le niveau choisi est invalide'
                ],
                'error_msg' => 'Le niveau est requis'
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'newNiveauLibelle',
            'rules' => [
                'required',
                'error_msg' => 'Le libellé est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'cycleName',
            'rules' => [
                'required',
                'error_msg' => 'Le nom du cycle est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'cyclesNumber',
            'rules' => [
                'required',
                'error_msg' => 'Le nom de cycles est requis'
            ],
            'process' => ['del_multiple_spaces']
        ],
    ],

    'edit-classe' => [
        [
            'name' => 'niveauId',
            'rules' => [
                'required',
                'type' => [
                    'value' => 'number',
                    'error_msg' => 'Le niveau choisi est invalide'
                ],
                'error_msg' => 'Le niveau est requis'
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'classeId',
            'rules' => [
                'required',
                'type' => [
                    'value' => 'number',
                    'error_msg' => 'La classe choisie est invalide'
                ],
                'error_msg' => 'La classe est requise'
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'newClasseLibelle',
            'rules' => [
                'required',
                'error_msg' => 'Le libellé est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
    ],

    'edit-student' => [
        [
            'name' => 'firstname',
            'rules' => [
                'min_length' => [
                    'value' => 1,
                    'error_msg' => 'Le prénom est trop court'
                ],
                'max_length' => [
                    'value' => 100,
                    'error_msg' => 'Le prénom est trop long'
                ],
                'error_msg' => 'Le prénom est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'lastname',
            'rules' => [
                'min_length' => [
                    'value' => 1,
                    'error_msg' => 'Le nom que vous avez saisi est trop court'
                ],
                'max_length' => [
                    'value' => 100,
                    'error_msg' => 'Le nom que vous avez saisi est trop long'
                ],
                'error_msg' => 'Le nom est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'email',
            'rules' => [
                'min_length' => [
                    'value' => 5,
                    'error_msg' => 'L\'adresse email est trop courte'
                ],
                'max_length' => [
                    'value' => 255,
                    'error_msg' => 'L\'adresse est trop longue'
                ],
                'error_msg' => 'L\'adresse email est requis'
            ],
            'process' => ['del_multiple_spaces', 'to_lower_case']
        ],
        [
            'name' => 'studentType',
            'rules' => [
                'type' => [
                    'value' => 'set',
                    'error_msg' => 'Le type ne répond pas aux citères',
                    'set_values' => ['externe', 'interne']
                ],
            ],
            'process' => ['del_all_spaces', 'to_lower_case']
        ],
        [
            'name' => 'birthdate',
            'rules' => [
                'type' => [
                    'value' => 'date',
                    'error_msg' => 'La date de naissance ne est invalide',
                ],
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'niveauId',
            'rules' => [
                'required',
                'error_msg' => 'Le niveau est requis',
                'type' => [
                    'value' => 'number',
                    'error_msg' => 'Le niveau choisi est invalide'
                ],
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'classeId',
            'rules' => [
                'required',
                'type' => [
                    'value' => 'number',
                    'error_msg' => 'La classe choisie est invalide'
                ],
                'error_msg' => 'La classe est requis'
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'phone',
            'rules' => [
                'type' => [
                    'value' => 'phone',
                    'error_msg' => 'Le numéro de téléphone saisi est invalide'
                ],
                'error_msg' => 'Le numéro saisi est requis'
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'address',
            'rules' => [],
            'process' => ['del_multiple_spaces']
        ],
    ],

    'create-user' => [
        [
            'name' => 'firstname',
            'rules' => [
                'required',
                'min_length' => [
                    'value' => 1,
                    'error_msg' => 'Le prénom est trop court'
                ],
                'max_length' => [
                    'value' => 100,
                    'error_msg' => 'Le prénom est trop long'
                ],
                'error_msg' => 'Le prénom est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'lastname',
            'rules' => [
                'required',
                'min_length' => [
                    'value' => 1,
                    'error_msg' => 'Le nom que vous avez saisi est trop court'
                ],
                'max_length' => [
                    'value' => 100,
                    'error_msg' => 'Le nom que vous avez saisi est trop long'
                ],
                'error_msg' => 'Le nom est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'username',
            'rules' => [
                'required',
                'min_length' => [
                    'value' => 4,
                    'error_msg' => 'Le nom d\'utilisateur que vous avez saisi est trop court'
                ],
                'max_length' => [
                    'value' => 100,
                    'error_msg' => 'Le nom d\'utilisateur que vous avez saisi est trop long'
                ],
                'error_msg' => 'Le nom d\'utilisateur est requis'
            ],
            'process' => ['del_all_spaces', 'to_lower_case']
        ],
        [
            'name' => 'email',
            'rules' => [
                'min_length' => [
                    'value' => 5,
                    'error_msg' => 'L\'adresse email est trop courte'
                ],
                'max_length' => [
                    'value' => 255,
                    'error_msg' => 'L\'adresse est trop longue'
                ],
                'error_msg' => 'L\'adresse email est requis'
            ],
            'process' => ['del_all_spaces', 'to_lower_case']
        ],
        [
            'name' => 'password',
            'rules' => [
                'required',
                'min_length' => [
                    'value' => 6,
                    'error_msg' => 'Le mot de passe est trop court'
                ],
                'max_length' => [
                    'value' => 25,
                    'error_msg' => 'Le mot de passe est trop long'
                ],
                'error_msg' => 'Le niveau est requis'
            ]
        ],
        [
            'name' => 'phone',
            'rules' => [
                'type' => [
                    'value' => 'phone',
                    'error_msg' => 'Le numéro de téléphone saisi est invalide'
                ],
                'error_msg' => 'Le numéro saisi est invalide'
            ],
            'process' => ['del_all_spaces']
        ],
    ],
    'login' => [
        [
            'name' => 'username',
            'rules' => [
                'required',
                'error_msg' => 'Le nom d\'utilisateur est requis'
            ],
            'process' => ['del_all_spaces', 'to_lower_case']

        ],
        [
            'name' => 'password',
            'rules' => [
                'required',
                'error_msg' => 'Le mot de passe est requis'
            ]
        ],
    ],
    'create-niveau' => [
        [
            'name' => 'niveauLibelle',
            'rules' => [
                'required',
                'error_msg' => 'Le libellé du niveau est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'cycleName',
            'rules' => [
                'required',
                'error_msg' => 'Le nom du cycle est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'cyclesNumber',
            'rules' => [
                'required',
                'error_msg' => 'Le nom de cycles est requis'
            ],
            'process' => ['del_multiple_spaces']
        ],
    ],
    'create-classe' => [
        [
            'name' => 'classeLibelle',
            'rules' => [
                'required',
                'error_msg' => 'Le libellé de la classe est requis'
            ],
            'process' => ['del_multiple_spaces', 'capitalize']
        ],
        [
            'name' => 'niveauId',
            'rules' => [
                'required',
                'error_msg' => 'Le niveau est requis'
            ],
            'process' => ['del_all_spaces']
        ],
    ],
    'delete-niveau' => [
        [
            'name' => 'niveauId',
            'rules' => [
                'required',
                'error_msg' => 'L\'id de niveau est requis'
            ],
            'process' => ['del_all_spaces']
        ]
    ],
    'delete-classe' => [
        [
            'name' => 'niveauId',
            'rules' => [
                'required',
                'error_msg' => 'L\'id de niveau est requis'
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'classeId',
            'rules' => [
                'required',
                'error_msg' => 'L\'id de la classe est requis'
            ],
            'process' => ['del_all_spaces']
        ],
    ],
    'delete-student' => [
        [
            'name' => 'studentId',
            'rules' => [
                'required',
                'error_msg' => "L'id de l'élève est requis"
            ],
            'process' => ['del_all_spaces']
        ],
    ],
    'create-year' => [
        [
            'name' => 'libelle',
            'rules' => [
                'required',
                'error_msg' => "Le libellé est requis",
                'regex' => [
                    'value' => '/\d{4}-\d{4}/',
                    'error_msg' => "Le format de l'année est invalide"
                ]
            ],
            'process' => ['del_all_spaces']
        ],
    ],
    'edit-year' => [
        [
            'name' => 'libelle',
            'rules' => [
                'required',
                'error_msg' => "Le libelle est requis",
                'regex' => [
                    'value' => '/\d{4}-\d{4}/',
                    'error_msg' => "Le format de l'année est invalide"
                ]
            ],
            'process' => ['del_all_spaces']
        ],
        [
            'name' => 'yearId',
            'rules' => [
                'required',
                'error_msg' => "L'id de l'année est requis",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de l'année est invalide"
                ]
            ],
            'process' => ['del_all_spaces']
        ],
    ],
    'delete-year' => [
        [
            'name' => 'yearId',
            'rules' => [
                'required',
                'error_msg' => "L'id de l'année est requis",
            ],
            'process' => ['del_all_spaces']
        ],
    ],
    'create-subject-group' => [
        [
            'name' => 'groupName',
            'rules' => [
                'required',
                'error_msg' => "Le nom du groupe est obligatoire",
                'min_length' => [
                    'value' => 1,
                    'error_msg' => 'Le nom du groupe est trop court'
                ],
                'max_length' => [
                    'value' => 25,
                    'error_msg' => 'Le nom du groupe est trop long'
                ]
            ],
            'process' => ['del_multiple_spaces', 'to_upper_case']
        ],
    ],
    'edit-subject-group' => [
        [
            'name' => 'groupName',
            'rules' => [
                'required',
                'error_msg' => "Le nom du groupe est obligatoire",
                'min_length' => [
                    'value' => 1,
                    'error_msg' => 'Le nom du groupe est trop court'
                ],
                'max_length' => [
                    'value' => 25,
                    'error_msg' => 'Le nom du groupe est trop long'
                ]
            ],
            'process' => ['del_multiple_spaces', 'to_upper_case']
        ],
        [
            'name' => 'groupId',
            'rules' => [
                'required',
                'error_msg' => "Aucun groupe sélectionné",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id du groupe est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
    ],
    'delete-subject-group' => [
        [
            'name' => 'groupId',
            'rules' => [
                'required',
                'error_msg' => "Aucun groupe sélectionné",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id du groupe est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
    ],
    'add-subject' => [
        [
            'name' => 'niveaux',
            'rules' => [
                'required',
                'error_msg' => "Aucun niveau sélectionné",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id du niveau sélectionné est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
        [
            'name' => 'classes',
            'rules' => [
                'required',
                'error_msg' => "Aucune classe sélectionnée",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de la classe sélectionnée est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
        [
            'name' => 'subjectGroup',
            'rules' => [
                'required',
                'error_msg' => 'Aucun groupe de disciplines sélectionné',
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id du groupe sélectionné est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
        [
            'name' => 'subject',
            'rules' => [
                'required',
                'error_msg' => 'Aucune discipline sélectionné',
            ],
            'process' => [
                'del_multiple_spaces',
            ]
        ],
    ],
    'create-subject' => [
        [
            'name' => 'groupId',
            'rules' => [
                'required',
                'error_msg' => "Aucun groupe sélectionné",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id du groupe est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
        [
            'name' => 'subjectName',
            'rules' => [
                'required',
                'error_msg' => "Le nom de la discipline est manquant"
            ],
            'process' => ['del_multiple_spaces', 'to_upper_case']
        ],
    ],
    'update-classe-subjects' => [
        [
            'name' => 'classeId',
            'rules' => [
                'required',
                'error_msg' => "Aucune classe sélectionnée",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de la classe est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
    ],
    'delete-classe-subject' => [
        [
            'name' => 'classeId',
            'rules' => [
                'required',
                'error_msg' => "Aucune classe sélectionnée",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de la classe est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
        [
            'name' => 'subjectId',
            'rules' => [
                'required',
                'error_msg' => "Aucune discipline sélectionnée",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de la discipline est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
    ],
    'update-coefs' => [
        [
            'name' => 'classeId',
            'rules' => [
                'required',
                'error_msg' => "Aucune classe sélectionnée",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de la classe est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
    ],
    'filter-notes' => [
        [
            'name' => 'classeId',
            'rules' => [
                'required',
                'error_msg' => "Aucune classe sélectionnée",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de la classe est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
        [
            'name' => 'subjectId',
            'rules' => [
                'required',
                'error_msg' => "Aucune discipline sélectionnée",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de la discipline est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
        [
            'name' => 'cycle',
            'rules' => [
                'required',
                'error_msg' => "Aucun cycle sélectionné",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "Le cycle sélectionné est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
        [
            'name' => 'noteType',
            'rules' => [
                'required',
                'error_msg' => "Aucun type de note sélectionné",
            ],
            'process' => ['del_multiple_spaces']
        ],
    ],
    'cd' => [
        [
            'name' => 'classeId',
            'rules' => [
                'required',
                'error_msg' => "Aucune classe sélectionnée",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de la classe est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
        [
            'name' => 'subjectId',
            'rules' => [
                'required',
                'error_msg' => "Aucune discipline sélectionnée",
                'type' => [
                    'value' => 'number',
                    'error_msg' => "L'id de la discipline est invalide"
                ]
            ],
            'process' => ['del_multiple_spaces']
        ],
    ],
];
