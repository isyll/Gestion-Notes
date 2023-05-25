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

        if ($this->session->get('create-niveau')) {
            $this->data['msg'] = $this->session->get('create-niveau-msg');

            if ($this->session->get('create-niveau-errors')) {
                $this->data['errors'] = $this->session->get('create-niveau-errors');
            }

            $this->session->remove(['create-niveau', 'create-niveau-msg', 'create-niveau-errors']);
        }

        $this->data['niveaux'] = $this->model->getNiveaux();

        echo $this->render('niveaux', $this->data);
    }

    public function createNiveau()
    {
        $this->session->set('create-niveau', true);

        $libelle = strtolower($this->helpers::rmms($_POST['niveauLibelle'] ?? ''));

        $this->fv->form([
            [
                'required' => true,
                'name' => 'niveauLibelle',
                'value' => $libelle,
                'min_length' => 1,
                'error_msg' => "Le libellé de niveau saisi est invalide"
            ]
        ]);

        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('create-niveau-msg', $this->error('Formulaire invalide'));
            if ($errors)
                $this->session->set('create-niveau-errors', $errors);
        } else {
            if ($this->model->niveauLibelleExists($libelle)) {
                $this->session->set('create-niveau-msg', $this->error('Ce niveau déjà'));
            } else {
                $libelle = $this->helpers::rmms($libelle);

                if ($this->model->saveNiveau($libelle)) {
                    $this->session->set('create-niveau-msg', $this->success('Niveau créée avec succès'));
                } else {
                    $this->session->set('create-niveau-msg', $this->error("Une erreur s'est produite lors de la création du niveau"));
                }
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }
}
