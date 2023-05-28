<?php

namespace App\Controller;

use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use App\Model\SchoolYearsModel;
use Core\Controller;

class ClassesController extends Controller
{
    private ClassesModel $model;
    private NiveauxModel $nm;
    private SchoolYearsModel $sym;

    public function __construct()
    {
        parent::__construct();
        $this->model = new ClassesModel($this->db);
        $this->nm    = new NiveauxModel($this->db);
        $this->sym   = new SchoolYearsModel($this->db);
    }

    public function getClasses($niveauId = NULL)
    {
        $this->data['niveauId'] = (int) $niveauId;

        if ($this->nm->niveauIdExists($this->data['niveauId'])) {
            $this->data['classes'] = $this->nm->getClasses($this->data['niveauId']);
        }

        echo $this->render('classes', $this->data);
    }

    public function createClasse()
    {
        $this->loadValidationRules('create-classe', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if ($this->nm->hasClasse((int) $_POST['niveauId'], $_POST['classeLibelle'])) {
                $this->session->set('msg', $this->error('Ce niveau possède déjà une classe nommée ' . $_POST['classeLibelle']));
            } else {
                if ($this->model->saveClasse($_POST['classeLibelle'], (int) $_POST['niveauId'])) {
                    $this->session->set('create-classe-msg', $this->success('Classe créée avec succès ' . $_POST['classeLibelle']));
                } else {
                    $this->session->set('create-classe-msg', $this->error('Une erreur est survenue lors de la création de la classe ' . $_POST['classeLibelle']));
                }
            }
        }

        $this->redirect($_POST['current-url'], false);
    }
}
