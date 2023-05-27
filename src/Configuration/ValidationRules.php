<?php

namespace App\Configuration;

class ValidationRules
{
    public static $datas = [
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
                ]
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
                ]
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
                ]
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
                ]
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
                ]
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
                ]
            ],
            [
                'name' => 'phone',
                'rules' => [
                    'type' => [
                        'value' => 'phone',
                        'error_msg' => 'Le numéro de téléphone saisi est invalide'
                    ],
                    'error_msg' => 'Le numéro saisi est requis'
                ]
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
                ]
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
                ]
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
                ]
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
                ]
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
                ]
            ],
        ],
        'login' => [
            [
                'name' => 'username',
                'rules' => [
                    'required',
                    'error_msg' => 'Le nom d\'utilisateur est requis'
                ]
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
                ]
            ]
        ],
        'create-classe' => [
            [
                'name' => 'classeLibelle',
                'rules' => [
                    'required',
                    'error_msg' => 'Le libellé de la est requis'
                ]
            ]
        ]
    ];
}
