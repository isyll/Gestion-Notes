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

    public function schoolYears(string $period)
    {
        $this->data['schoolYears'] = $this->model->getYears();

        $y = ((int) date('Y')) - 5;
        for ($i = $y; $i < $y + 15; $i++) {
            $i2                      = $i + 1;
            $this->data['periods'][] = "$i - $i2";
        }

        if ($this->request['method'] === 'POST') {
            $_POST['period'] = Helpers::rms($_POST['period']);

            $fv = new FormValidator([
                [
                    'name' => 'period',
                    'required' => true,
                    'value' => $_POST['period'] ?? '',
                    'regex' => '/^[0-9]{4}\s?-\s?[0-9]{4}$/',
                ]
            ]);

            $fv->validate();

            if (count($this->data['errors'] = $fv->getErrors()) > 0) {
                $this->data['msg'] = Helpers::msg('Formulaire invalide', 'danger');
            } else {
                if ($this->model->periodExist($_POST['period'])) {
                    $this->data['msg'] = Helpers::msg('Année déjà existante', 'danger');
                } else {
                    $this->model->saveYear([
                        'period' => $_POST['period']
                    ]);
                    $this->data['msg'] = Helpers::msg('Année créée avec succès');
                    $this->data['schoolYears'] = $this->model->getYears();
                }

            }
        } else {
            if ($period !== '') {
                if (!$this->model->periodExist($period))
                    $this->data['msg'] = Helpers::msg("L'année $period n'existe pas!", 'danger');
            }
        }

        echo $this->render('admin', $this->data);
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
