<?php

namespace App\Controller;

use Core\Controller;

class SubjectsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function page()
    {
        $this->data['niveaux'] = $this->niveauxModel->getNiveaux();
        $this->data['groups']  = $this->subjectsModel->getGroups();

        echo $this->render('subjects', $this->data, NULL, false, ['subjects']);
    }

    public function createGroup()
    {
        $this->loadValidationRules('create-subject-group', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } elseif ($this->subjectsModel->groupNameExists($_POST['groupName'])) {
            $this->session->set('msg', $this->error('Ce nom appartient déjà à un autre groupe'));
        } else {
            if ($this->subjectsModel->saveGroup($_POST))
                $this->session->set('msg', $this->success('Groupe créé avec succès'));
            else
                $this->session->set('msg', $this->error("Une erreur inconnue s'est produite lors de l'insertion"));
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }
}
