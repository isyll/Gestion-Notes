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
        $this->data['niveauId']   = $this->model->getNiveauId($period, $niveauSlug);

        if ($this->sym->yearExistPeriod($period)) {
            if ($this->sym->containsNiveau($period, $niveauSlug)) {
                $this->data['classes'] = $this->model->getClasses($period, $niveauSlug);
                if (count($this->data['classes']) === 0) {
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

        $fv = new FormValidator([
            [
                'required' => true,
                'name' => 'period',
                'value' => $period,
                'error_msg' => "Le libellé de niveau saisi est invalide"
            ],
            [
                'required' => true,
                'name' => 'niveauSlug',
                'value' => $niveauSlug,
                'error_msg' => "Le niveau est invalide"
            ],
            [
                'required' => true,
                'name' => 'libelleClasse',
                'value' => $libelleClasse,
                'error_msg' => "Le libellé de classe saisi est invalide"
            ],
        ]);

        $fv->validate();

        if (count($this->data['errors'] = $fv->getErrors()) > 0) {
            $this->data['msg'] = $this->error('Formulaire invalide');
            dd('invalide');
        } else {
            if ($this->model->classeExist((int) $_POST['niveauId'], $_POST['libelleClasse'])) {
                $this->data['msg'] = $this->error('Ce niveau possède déjà une classe nommée ' . $_POST['libelleClasse']);
                dd('existe déjà');
            } else {
                if ($this->model->saveClasse($_POST)) {
                    dd("ok");
                } else {
                    dd('erreur');
                }
            }
        }
    }
}
