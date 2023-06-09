<?php

namespace App\Controller;

use App\BaseController;
use Core\Router;

class SubjectsController extends BaseController
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

    public function classeCoef($classeId = NULL)
    {
        if (
            $classeId
            && $this->data['classe'] = $this->classesModel->getClasseById($classeId)
        ) {
            $this->data['niveau']    = $this->classesModel->getClasseNiveau($classeId);
            $this->data['noteTypes'] = $this->classesModel->getClasseNoteTypes($this->data['classe']['id']);
            $this->data['subjects']  = $this->subjectsModel->getClasseSubjects($classeId);

            $this->data['noteMax'] = $this->classesModel->getClasseNotesMax($this->data['classe']['id']);
            $this->data['filter']  = $this->filterFunction();
        } else
            Router::pageNotFound();

        echo $this->render('classe-coef', $this->data, NULL, false, ['coefs']);
    }

    private function filterFunction()
    {
        return function (array $notes, int $subjectId, string $noteType) {
            foreach ($notes as $n) {
                if (
                    $n['nom_type'] == $noteType &&
                    $n['id_discipline'] == $subjectId
                )
                    return $n['max_note'];
            }

            return false;
        };
    }

    public function addSubject()
    {
        $this->loadValidationRules('add-subject', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function delClasseSubject()
    {
        $this->loadValidationRules('delete-classe-subject', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } elseif (!$this->classesModel->getClasseById($_POST['classeId'])) {
            $this->session->set('msg', $this->error("Cette classe n'existe pas"));
        } elseif (!$this->subjectsModel->getSubjectById($_POST['subjectId'])) {
            $this->session->set('msg', $this->error("Cette discipline n'existe pas"));
        } else {
            $this->subjectsModel->delSubjectFromClasse($_POST['classeId'], $_POST['subjectId'], $this->data['yearInfos']['id']);
            $this->session->set('msg', $this->success("Discipline supprimée avec succès"));
        }

        $this->redirect($_POST['current-url'] ?? '', false);
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
