<?php

namespace App\Controller;

use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use App\Model\SchoolYearsModel;
use Core\Controller;
use Core\FormValidator;

class NiveauxController extends Controller
{
    private NiveauxModel $model;

    private ClassesModel $cm;

    private SchoolYearsModel $sym;

    public function __construct()
    {
        parent::__construct();
        $this->model = new NiveauxModel($this->db);
        $this->cm    = new ClassesModel($this->db);
        $this->sym   = new SchoolYearsModel($this->db);
    }

    public function getNiveaux()
    {
        $this->data['current'] = 'niveaux';
        $this->data['title']   = 'Niveaux';
        $this->data['niveaux'] = $this->model->getNiveaux();

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
            if ($this->model->niveauLibelleExists($_POST['niveauLibelle'])) {
                $this->session->set('msg', $this->error('Ce niveau déjà'));
            } else {
                if ($this->model->saveNiveau($_POST['niveauLibelle'])) {
                    $this->session->set('msg', $this->success('Niveau créée avec succès'));
                } else {
                    $this->session->set('msg', $this->error("Une erreur inconnue s'est produite"));
                }
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }
}
