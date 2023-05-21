<?php

namespace App\Controller;

use App\Model\AdminModel;
use Core\Controller;
use Core\Database;
use Core\FormValidator;
use Core\Helpers;

class AdminController extends Controller
{
    private AdminModel $model;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->model = new AdminModel($db);
    }

    public function createUser()
    {
        $datasForm = [
            [
                'name' => 'username',
                'required' => true,
                'value' => $_POST['username'] ?? '',
                'regex' => '/^[a-zA-Z]{1,}[a-zA-Z0-9]*$/',
                'min_length' => 5,
                'max_length' => 25
            ],
            [
                'name' => 'email',
                'required' => true,
                'value' => $_POST['email'] ?? '',
                'regex' => '/^[A-Za-z0-9]+@[A-Za-z0-9]+\.[A-Za-z0-9]{2,}$/',
                'max_length' => 255
            ],
            [
                'name' => 'password',
                'required' => true,
                'value' => $_POST['password'] ?? '',
                'regex' => '/^(?=.*[A-Za-z])(?=.*\d)[a-zA-Z\d]{6,}$/',
                'min_length' => 6,
                'max_length' => 30
            ],
            [
                'name' => 'firstname',
                'required' => true,
                'value' => $_POST['firstname'] ?? '',
                'max_length' => 255
            ],
            [
                'name' => 'lastname',
                'required' => true,
                'value' => $_POST['lastname'] ?? '',
                'max_length' => 255
            ],
            [
                'name' => 'phone',
                'required' => true,
                'value' => $_POST['phone'] ?? '',
                'max_length' => 255
            ],
            [
                'name' => 'adresse',
                'required' => false,
                'value' => $_POST['address'] ?? '',
                'max_length' => 255
            ],
        ];

        if ($this->request['method'] === 'POST') {

            $fv = new FormValidator($datasForm);

            $fv->validate();
            $this->data['errors'] = $fv->getErrors();

            if (count($this->data['errors']) > 0) {
                $this->data['msg'] = [
                    'type' => 'danger',
                    'value' => "Erreur de validation des champs"
                ];
            } else {
                $hashedPass = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $hash       = PASSWORD_DEFAULT;

                $this->model->saveUser(
                    [
                        'username' => $_POST['username'],
                        'passwordHash' => $hashedPass,
                        'hash' => $hash,
                        'email' => $_POST['email'],
                        'firstname' => $_POST['firstname'],
                        'lastname' => $_POST['lastname'],
                        'phone' => $_POST['phone'],
                        'address' => $_POST['address'] ?? NULL
                    ]
                );
                $this->data['msg'] = [
                    'type' => 'success',
                    'value' => "Utilisateur créé avec succès"
                ];
            }
        } else {
            $this->data = [];
        }

        echo $this->render('create-user', $this->data);
    }
}
