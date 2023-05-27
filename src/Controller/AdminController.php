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

    public function __construct()
    {
        parent::__construct();
        $this->model = new AdminModel($this->db);
    }

    public function createUser()
    {
        $this->loadValidationRules('create-user', $_POST);

        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if (false) {

            } elseif (false) {

            } else {
                $_POST['phone']          = $this->helpers::rms($_POST['phone']);
                $_POST['hash_algorithm'] = PASSWORD_DEFAULT;
                $_POST['password_hash']  = password_hash($_POST['password'], $_POST['hash_algorithm']);

                $this->model->saveUser($_POST);
                $this->session->set('msg', $this->success('Utilisateur créé avec succès'));
            }
        }

        echo $this->render($_POST['current-url'], $this->data);
    }
}
