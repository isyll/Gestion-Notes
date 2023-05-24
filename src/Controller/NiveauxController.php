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

    public function getNiveaux(string $period = NULL)
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

        if ($this->sym->yearExistPeriod($period)) {
            $this->data['exists']  = true;
            $this->data['niveaux'] = $this->model->getSYNiveauxByPeriod($period);
            $this->data['period']  = $period;
            $this->data['yearId']  = $this->sym->getYearByPeriod($period)['id'];

            if (count($this->data['niveaux']) === 0) {
                $this->data['msg'] = $this->data = $this->success("L'année scolaire {$period} ne possède aucun niveau");
            }
        } else {
            $this->data['exists'] = false;
            $this->data['msg']    = $this->error("L'année scolaire {$period} n'existe pas");
        }

        echo $this->render('niveaux', $this->data);
    }

    public function createNiveau()
    {
        $this->session->set('create-niveau', true);

        $libelle = $this->helpers::rmms($_POST['libelleNiveau'] ?? '');
        $period  = $_POST['period'] ?? '';
        $yearId  = (int) $_POST['yearId'] ?? '';

        $fv = new FormValidator([
            [
                'required' => true,
                'name' => 'libelleNiveau',
                'value' => $libelle,
                'min_length' => 1,
                'error_msg' => "Le libellé de niveau saisi est invalide"
            ],
            [
                'required' => true,
                'name' => 'period',
                'value' => $period,
                'error_msg' => "L'année est invalide"
            ],
            [
                'required' => true,
                'name' => 'yearId',
                'value' => $yearId,
                'type' => 'numeric',
                'error_msg' => "L'année est invalide"
            ]
        ]);

        $fv->validate();

        if (count($errors = $fv->getErrors()) > 0) {
            $this->session->set('create-niveau-msg', $this->error('Formulaire invalide'));
            $this->session->set('create-niveau-errors', $errors);
        } else {
            if ($this->model->niveauExist($_POST['libelleNiveau'])) {
                $this->session->set('create-niveau-msg', $this->error('Ce niveau déjà'));
            } else {
                if ($this->sym->yearExist($yearId)) {
                    $libelle = $this->helpers::rmms($libelle);
                    $slug    = str_replace(' ', '-', $libelle);

                    if ($this->model->saveNiveau($libelle, $slug, $yearId)) {
                        $this->session->set('create-niveau-msg', $this->success('Niveau créée avec succès'));
                    } else {
                        $this->session->set('create-niveau-msg', $this->error("Une erreur s'est produite lors de la création du niveau"));
                    }
                } else {
                    $this->session->set('create-niveau-msg', $this->error("L'année scolaire sélectionné n'existe pas"));
                }
            }
        }

        $this->redirect("/{$this->data['urls']['base']}/$period/");
    }
}
