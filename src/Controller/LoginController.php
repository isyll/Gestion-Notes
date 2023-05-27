<?php

namespace App\Controller;

use App\Model\AdminModel;
use Core\Controller;

class LoginController extends Controller
{
    private AdminModel $adminModel;

    public function __construct()
    {
        parent::__construct();
        $this->adminModel = new AdminModel($this->db);
    }

    public function connection()
    {
        echo $this->render('login', $this->data);
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
                $this->session->set('msg', $this->error("Connexion refusée"));
            }
        }

        $this->redirect($_POST['current-url'], false);
    }

    public function logout()
    {
        $this->userLogout();
    }
}
