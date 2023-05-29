<?php

namespace App\Controller;

use Core\Controller;

class ClassesController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getClasses($niveauId = NULL)
    {
        $this->data['niveauId'] = (int) $niveauId;

        if ($this->niveauxModel->niveauIdExists($this->data['niveauId'])) {
            $this->data['niveau']  = $this->niveauxModel->getNiveauById($this->data['niveauId']);
            $this->data['classes'] = $this->niveauxModel->getClasses($this->data['niveauId']);
        }

        echo $this->render('classes', $this->data);
    }

    public function newClasse($niveauId)
    {
        $niveauId = (int) $niveauId;

        if ($this->niveauxModel->niveauIdExists($niveauId)) {
            $this->data['niveau'] = $this->niveauxModel->getNiveauById($niveauId);
        }

        echo $this->render('new-classe', $this->data);
    }

    public function createClasse()
    {
        $this->loadValidationRules('create-classe', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if ($this->niveauxModel->hasClasseLibelle((int) $_POST['niveauId'], $_POST['classeLibelle'])) {
                $this->session->set('msg', $this->error('Ce niveau possède déjà une classe nommée ' . $_POST['classeLibelle']));
            } else {
                if ($this->classesModel->saveClasse($_POST['classeLibelle'], (int) $_POST['niveauId'])) {
                    $this->session->set('msg', $this->success("Classe {$_POST['classeLibelle']} a été créée avec succès"));
                    $this->redirect($this->data['urls']['list-classes'] . $_POST['niveauId'], false);
                } else {
                    $this->session->set('msg', $this->error('Une erreur est survenue lors de la création de la classe ' . $_POST['classeLibelle']));
                }
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function deleteClasse()
    {
        $this->loadValidationRules('delete-classe', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if ($this->classesModel->classeNiveauMatch((int) $_POST['niveauId'], (int) $_POST['classeId'])) {
                if ($this->classesModel->deleteClasse((int) $_POST['niveauId'], (int) $_POST['classeId']))
                    $this->session->set('msg', $this->success('La classe a bien été supprimé'));
                else
                    $this->session->set('msg', $this->error('Une erreur inconnue est survenue lors de la suppression'));
            } else {
                $this->session->set('msg', $this->error('Le niveau sélectionné ne possède pas cette classe'));
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    private function control(int $niveauId, int $classeId): bool
    {
        return true;
    }
}
