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

        if ($this->session->get('create-classe')) {
            $this->data['msg'] = $this->session->get('create-classe-msg');

            if ($this->session->get('create-classe-errors')) {
                $this->data['errors'] = $this->session->get('create-classe-errors');
            }

            $this->session->remove(['create-classe', 'create-classe-msg', 'create-classe-errors']);
        }

        if ($this->nm->niveauIdExists($this->data['niveauId'])) {
            $this->data['classes'] = $this->nm->getClasses($this->data['niveauId']);
        }

        echo $this->render('classes', $this->data);
    }

    public function createClasse()
    {
        $this->session->set('create-classe', true);

        $niveauId      = (int) $_POST['niveauId'] ?? '';
        $classeLibelle = $_POST['classeLibelle'] ?? '';

        $this->loadValidationRules('create-classe', $_POST);

        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('create-classe-msg', $this->error('Formulaire invalide'));
            $this->session->set('create-classe-errors', $errors);
        } else {
            if ($this->nm->hasClasse($niveauId, $classeLibelle)) {
                $this->session->set('create-classe-msg', $this->error('Ce niveau possède déjà une classe nommée ' . $classeLibelle));
            } else {
                $classeLibelle = $this->helpers::rmms($classeLibelle);

                if ($this->model->saveClasse($classeLibelle, $niveauId)) {
                    $this->session->set('create-classe-msg', $this->success('Classe créée avec succès ' . $classeLibelle));

                } else {
                    $this->session->set('create-classe-msg', $this->error('Une erreur est survenue lors de la création de la classe ' . $classeLibelle));
                }
            }
        }

        $this->redirect($_POST['current-url'], false);
    }
}
