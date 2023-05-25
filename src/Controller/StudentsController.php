<?php

namespace App\Controller;

use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use App\Model\SchoolYearsModel;
use App\Model\StudentsModel;
use Core\Controller;

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

    public function list(
        string $niveauId = NULL,
        string $classeId = NULL
    ) {
        $this->data['niveauId'] = (int) $niveauId;
        $this->data['classeId'] = (int) $classeId;

        if ($this->session->get('create-student')) {
            $this->data['msg'] = $this->session->get('create-student-msg');

            if ($this->session->get('create-student-errors')) {
                $this->data['errors'] = $this->session->get('create-student-errors');
            }

            $this->session->remove(['create-student', 'create-student-msg', 'create-student-errors']);
        }

        if ($this->nm->niveauIdExists($this->data['niveauId'])) {
            $classe = $this->cm->getClasseById($this->data['classeId']);

            if ($classe) {
                if ($this->nm->hasClasse($this->data['niveauId'], $classe['libelle'])) {
                    $this->data['students'] = $this->nm->getClasses($this->data['niveauId']);
                } else {
                    $this->data['msg'] = $this->error("Le niveau sélectionné ne possède pas cette classe");
                }
            } else {
                $this->data['msg'] = $this->error("La classe sélectionnée n'existe pas");
            }
        }

        echo $this->render('students', $this->data);
    }

    public function createStudent()
    {
        $this->session->set('create-student', true);

        $fn        = $_POST['firstname'] ?? '';
        $ln        = $_POST['lastname'] ?? '';
        $email     = $_POST['email'] ?? '';
        $phone     = $this->helpers->rmms($_POST['phone'] ?? '');
        $adresse   = $_POST['address'] ?? '';
        $birthdate = $_POST['birthdate'] ?? '';
        $type      = $_POST['type'] ?? '';
        $niveauId  = $_POST['niveauId'] ?? '';
        $classeId  = $_POST['classeId'] ?? '';

        $this->fv->form([
            [
                'required' => true,
                'name' => 'firstname',
                'value' => $fn,
                'error_msg' => "Le prénom $fn est invalide"
            ],
            [
                'required' => true,
                'name' => 'lastname',
                'value' => $ln,
                'error_msg' => "Le nom $ln est invalide"
            ],
            [
                'required' => true,
                'name' => 'email',
                'type' => 'email',
                'value' => $email,
            ],
            [
                'required' => true,
                'name' => 'phone',
                'value' => $phone,
            ],
            [
                'required' => false,
                'name' => 'address',
                'value' => $adresse,
            ],
            [
                'required' => false,
                'name' => 'birthdate',
                'value' => $birthdate,
            ],
            [
                'required' => true,
                'name' => 'type',
                'value' => $type,
                'type' => 'set',
                'set_values' => ['externe', 'interne']
            ],
        ]);

        $this->fv->validate();

        if (count($errors = $this->fv->getErrors()) > 0) {
            $this->session->set('create-student-msg', $this->error('Formulaire invalide'));
            $this->session->set('create-student-errors', $errors);

        } else {
            $this->session->set('create-student-msg', $this->success("Elève enregistré"));

        }

        $this->redirect($_POST['current-url']);
    }
}
