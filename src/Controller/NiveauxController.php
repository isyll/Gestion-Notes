<?php

namespace App\Controller;

use App\BaseController;
use Core\Helpers;

class NiveauxController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getNiveaux()
    {
        $this->data['current'] = 'niveaux';
        $this->data['niveaux'] = $this->niveauxModel->getNiveaux();

        echo $this->render('niveaux', $this->data);
    }

    public function createNiveau()
    {
        $this->loadValidationRules('create-niveau', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if ($this->niveauxModel->niveauLibelleExists($_POST['niveauLibelle'])) {
                $this->session->set('msg', $this->error('Ce niveau déjà'));
            } else {
                if ($this->niveauxModel->saveNiveau($_POST)) {
                    $this->session->set('msg', $this->success('Niveau créée avec succès'));
                    $this->redirect($this->data['urls']['list-niveaux'], false);
                } else {
                    $this->session->set('msg', $this->error("Une erreur inconnue s'est produite"));
                }
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function deleteNiveau()
    {
        $this->loadValidationRules('delete-niveau', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if ($this->niveauxModel->niveauIdExists((int) $_POST['niveauId'])) {
                if ($this->niveauxModel->deleteNiveau((int) $_POST['niveauId']))
                    $this->session->set('msg', $this->success('Le niveau a bien été supprimé'));
                else
                    $this->session->set('msg', $this->error('Une erreur inconnue est survenue lors de la suppression'));
            } else {
                $this->session->set('msg', $this->error('Le niveau sélectionné n\'existe pas'));
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function edit()
    {
        $this->loadValidationRules('edit-niveau', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if (isset($_POST['niveauId']) && $this->niveauxModel->niveauIdExists((int) $_POST['niveauId'])) {
                if ($this->niveauxModel->editNiveau($_POST))
                    $this->session->set('msg', $this->success('Le niveau a bien été modifié'));
                else
                    $this->session->set('msg', $this->error('Une erreur inconnue est survenue lors de la suppression'));
            } else {
                $this->session->set('msg', $this->error('Le niveau sélectionné n\'existe pas'));
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }
}
