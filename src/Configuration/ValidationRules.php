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
                    'error_msg' => 'Le prénom est invalide'
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
                    'error_msg' => 'Le nom est invalide'
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
                    'error_msg' => 'L\'adresse email est invalide'
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
                    'error_msg' => 'Le type est invalide'
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
                    'error_msg' => 'Le niveau est invalide'
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
                    'error_msg' => 'La classe est invalide'
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
                    'error_msg' => 'Le prénom est invalide'
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
                    'error_msg' => 'Le nom est invalide'
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
                    'error_msg' => 'L\'adresse email est invalide'
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
                    'error_msg' => 'Le niveau est invalide'
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
        ]

    ];
}
