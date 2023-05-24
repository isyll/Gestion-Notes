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

        if ($this->sym->yearExistPeriod($period)) {
            if ($this->sym->containsNiveau($period, $niveauSlug)) {
                $this->data['classes'] = $this->model->getClasses($period, $niveauSlug);
                if (count($this->data['classes']) === 0) {
                    $this->data['msg'] = Helpers::msg("Le niveau $niveauSlug ne possède aucune classe", 'danger');
                }
            } else {
                $this->data['msg'] = Helpers::msg("L'année $period ne possède pas de niveau $niveauSlug");
            }
        } else {
            $this->data['msg'] = Helpers::msg("L'année $period n'existe pas.");
        }

        echo $this->render('classes', $this->data);
    }

    public function createClasse()
    {
        $fv = new FormValidator([
            [
                'required' => true,
                'name' => 'libelleNiveau',
                'value' => $_POST['libelleNiveau'] ?? '',
            ],
            [
                'required' => true,
                'name' => 'libelleClasse',
                'value' => $_POST['libelleClasse'] ?? '',
            ],
        ]);

        $fv->validate();

        if (count($this->data['errors'] = $fv->getErrors()) > 0) {
            $this->data['msg'] = Helpers::msg('Formulaire invalide', 'danger');
        } else {
            // if ($this->model->classeExist((int) $_POST['niveauId'], $_POST['libelleClasse'])) {
            //     $this->data['msg'] = Helpers::msg('Ce niveau possède déjà une classe nommée ' . $_POST['libelleClasse'], 'danger');
            // } else {
            //     $this->model->saveClasse($_POST);
            //     $this->data['msg']     = Helpers::msg('Classe créée avec succès');
            // }
        }
    }
}
