<?php

namespace App\Controller;

use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use App\Model\SchoolYearsModel;
use Core\Controller;
use Core\FormValidator;
use Core\Helpers;

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

    public function getClasses($period = NULL, $niveauSlug = NULL)
    {
        $this->data['period']     = $period;
        $this->data['niveauSlug'] = $niveauSlug;
        $this->data['niveauId']   = $this->model->getNiveauId($period, $niveauSlug)['id'];

        if ($this->session->get('create-classe')) {
            $this->data['msg'] = $this->session->get('create-classe-msg');

            if ($this->session->get('create-classe-errors')) {
                $this->data['errors'] = $this->session->get('create-classe-errors');
            }

            $this->session->remove(['create-classe', 'create-classe-msg', 'create-classe-errors']);
        }

        if ($this->sym->yearExistPeriod($period)) {
            $this->data['yearId'] = $this->sym->getYearByPeriod($period)['id'];

            if ($this->sym->containsNiveau($period, $niveauSlug)) {
                $this->data['classes'] = $this->model->getClasses($period, $niveauSlug);
                if (!$this->data['classes']) {
                    $this->data['msg'] = $this->success("Le niveau $niveauSlug ne possède aucune classe");
                }
            } else {
                $this->data['msg'] = $this->error("L'année $period ne possède pas de niveau $niveauSlug");
            }
        } else {
            $this->data['msg'] = Helpers::msg("L'année $period n'existe pas.");
        }

        echo $this->render('classes', $this->data);
    }

    public function createClasse()
    {
        $this->session->set('create-classe', true);

        $period        = $_POST['period'] ?? '';
        $niveauSlug    = $_POST['niveauSlug'] ?? '';
        $libelleClasse = $_POST['libelleClasse'] ?? '';
        $niveauId      = $_POST['niveauId'] ?? '';

        $fv = new FormValidator([
            [
                'required' => true,
                'name' => 'period',
                'value' => $period,
                'error_msg' => "L'année '$period' est invalide"
            ],
            [
                'required' => true,
                'name' => 'niveauSlug',
                'value' => $niveauSlug,
                'error_msg' => "Le niveau '$niveauSlug' est invalide"
            ],
            [
                'required' => true,
                'name' => 'libelleClasse',
                'value' => $libelleClasse,
                'error_msg' => "Le libellé '$libelleClasse' est invalide"
            ],
        ]);

        $fv->validate();

        if (count($errors = $fv->getErrors()) > 0) {
            $this->session->set('create-classe-msg', $this->error('Formulaire invalide'));
            $this->session->set('create-classe-errors', $errors);
        } else {
            if ($this->model->classeExist((int) $_POST['niveauId'], $_POST['libelleClasse'])) {
                $this->session->set('create-classe-msg', $this->error('Ce niveau possède déjà une classe nommée ' . $_POST['libelleClasse']));
            } else {
                $libelleClasse = $this->helpers::rmms($libelleClasse);
                $slug          = str_replace(' ', '-', $libelleClasse);

                if ($this->model->saveClasse($libelleClasse, $slug, $niveauId)) {
                    $this->session->set('create-classe-msg', $this->success('Classe créée avec succès ' . $_POST['libelleClasse']));

                } else {
                    $this->session->set('create-classe-msg', $this->error('Une erreur est survenue lors de la création de la classe ' . $_POST['libelleClasse']));

                }
            }
        }

        $this->redirect("/{$this->data['urls']['base']}/$period/$niveauSlug");
    }
}
