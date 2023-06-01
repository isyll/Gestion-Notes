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

        if ($this->data['selectedGroup'] = $this->session->get('selectedGroupId'))
            $this->session->remove('selectedGroupId');

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
            if ($this->subjectsModel->saveGroup($_POST)) {
                $this->session->set('msg', $this->success('Groupe créé avec succès'));
                $this->session->set('selectedGroupId', $this->db->getPDO()->lastInsertId());
            } else
                $this->session->set('msg', $this->error("Une erreur inconnue s'est produite lors de l'insertion"));
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function deleteGroup()
    {
        $this->loadValidationRules('delete-subject-group', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } elseif (!$this->subjectsModel->groupIdExists($_POST['groupId'])) {
            $this->session->set('msg', $this->error("Le groupe sélectionné n'existe pas"));
        } else {
            if ($this->subjectsModel->deleteGroupById($_POST['groupId'])) {
                $this->session->set('msg', $this->success('Groupe supprimé avec succès'));
            } else
                $this->session->set('msg', $this->error("Une erreur inconnue s'est produite lors de l'insertion"));
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function editGroup()
    {
        $this->loadValidationRules('edit-subject-group', $_POST);
        $this->fv->validate();
        $this->session->set('selectedGroupId', $_POST['groupId'] ?? NULL);

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } elseif (!$this->subjectsModel->groupIdExists($_POST['groupId'])) {
            $this->session->set('msg', $this->error("Le groupe sélectionné n'existe pas"));
        } else {
            $this->subjectsModel->deleteGroupById($_POST['groupId']);

            if ($this->subjectsModel->getGroupByName($_POST['groupName'])) {
                $this->session->set('msg', $this->error('Ce nom appartient déjà à un autre groupe'));
            } else {
                if ($this->subjectsModel->editGroup($_POST['groupId'], $_POST))
                    $this->session->set('msg', $this->success('Groupe modifié avec succès'));
                else
                    $this->session->set('msg', $this->error("Une erreur inconnue s'est produite lors de l'insertion"));
            }

            $this->subjectsModel->restoreGroupById($_POST['groupId']);
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }
}
