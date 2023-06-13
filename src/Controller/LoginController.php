<?php

namespace App\Controller;

use App\BaseController;

class LoginController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function connection()
    {
        echo $this->render('login', $this->data, false, true);
    }

    public function login()
    {
        $this->loadValidationRules('login', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('form-errors', $errors);
        } else {
            if ($datas = $this->adminModel->login($_POST['username'], $_POST['password'])) {
                $this->userLogin($datas);
                $this->session->set('msg', $this->success('Connexion effectuée'));
            } else {
                $this->session->set('msg', $this->error("Identifiant/Mot de passe invalide"));
            }
        }

        $this->redirect($_POST['current-url'], false);
    }

    public function logout()
    {
        $this->userLogout();
    }
}
