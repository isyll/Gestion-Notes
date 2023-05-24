<?php

namespace App\Controller;

use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use App\Model\SchoolYearsModel;
use App\Model\StudentsModel;
use Core\Controller;
use Core\Database;
use Core\FormValidator;
use Core\Helpers;

class StudentsController extends Controller
{
    private StudentsModel $model;
    private SchoolYearsModel $sym;
    private NiveauxModel $nm;
    private ClassesModel $cm;

    public function __construct()
    {
        parent::__construct();
        $this->model = new StudentsModel($this->db);
        $this->sym   = new SchoolYearsModel($this->db);
        $this->nm    = new NiveauxModel($this->db);
        $this->cm    = new ClassesModel($this->db);
    }

    public function studentsList(
        string $period = NULL,
        string $niveauSlug = NULL,
        string $classeSlug = NULL
    ) {
        $this->data['period']     = $period;
        $this->data['niveauSlug'] = $niveauSlug;
        $this->data['classeSlug'] = $classeSlug;

        if ($this->sym->yearExistPeriod($period)) {
            if ($this->sym->containsNiveau($period, $niveauSlug)) {
                if ($this->model->containsClasse($period, $niveauSlug, $classeSlug)) {
                    $this->data['students'] = $this->model->getAllStudents($period, $niveauSlug, $classeSlug);
                } else {
                    $this->data['msg'] = Helpers::msg("Le niveau $niveauSlug ne possède pas de de classe $classeSlug");
                }
            } else {
                $this->data['msg'] = Helpers::msg("L'année $period ne possède pas de niveau $niveauSlug");
            }
        } else {
            $this->data['msg'] = Helpers::msg("L'année $period n'existe pas.");
        }

        echo $this->render('classes', $this->data);
    }

    public function createStudent()
    {
        $fv = new FormValidator([
            [
                'required' => true,
                'name' => 'prénom',
                'value' => $_POST['firstname'] ?? '',
            ],
            [
                'required' => true,
                'name' => 'nom',
                'value' => $_POST['lastname'] ?? '',
            ],
            [
                'required' => true,
                'name' => 'email',
                'type' => 'email',
                'value' => $_POST['email'] ?? '',
            ],
            [
                'required' => true,
                'name' => 'numéro',
                'value' =>
                ($_POST['phone'] = Helpers::rmms($_POST['phone'] ?? '')) ?? '',
            ],
            [
                'required' => false,
                'name' => 'adresse',
                'value' => $_POST['adresse'] ?? '',
            ],
            [
                'required' => true,
                'name' => 'type',
                'value' => $_POST['type'] ?? '',
                'type' => 'set',
                'set_values' => ['externe', 'interne']
            ],
        ]);

        $fv->validate();

        if (count($this->data['errors'] = $fv->getErrors()) > 0) {
            $this->data['msg'] = Helpers::msg('Formulaire invalide', 'danger');
        } else {
            if (count($this->model->getStudentByPhone($_POST['phone'])) > 0) {
                $this->data['msg'] = Helpers::msg('Le numéro saisi est déjà enregistré', 'danger');
            } else if (count($this->model->getStudentByEmail($_POST['email'])) > 0) {
                $this->data['msg'] = Helpers::msg("L'email saisi est déjà enregistré", 'danger');
            } else {
                $this->model->saveStudent($_POST);
                $this->data['msg'] = Helpers::msg('Classe créée avec succès');
            }
        }
    }
}
