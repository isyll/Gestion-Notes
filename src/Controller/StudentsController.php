<?php

namespace App\Controller;

use Core\Controller;

class StudentsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function list(
        $niveauId = NULL,
        $classeId = NULL
    ) {
        $this->data['niveauId'] = (int) $niveauId;
        $this->data['classeId'] = (int) $classeId;

        if ($this->niveauxModel->niveauIdExists($this->data['niveauId'])) {
            $classe = $this->classesModel->getClasseById($this->data['classeId']);

            if ($classe) {
                if ($this->niveauxModel->hasClasse($this->data['niveauId'], $classe['libelle'])) {
                    $this->data['students'] = $this->classesModel->getStudents($this->data['classeId']);
                } else {
                    $this->data['msg'] = $this->error("Le niveau sélectionné ne possède pas cette classe");
                }
            } else {
                $this->data['msg'] = $this->error("La classe sélectionnée n'existe pas");
            }
        }

        echo $this->render('students', $this->data);
    }

    public function newStudent()
    {
        $this->data['niveaux'] = $this->niveauxModel->getNiveaux();

        echo $this->render('new-student', $this->data);
    }

    public function createStudent()
    {
        $_POST['numero'] = rand(1, 10000);

        $this->loadValidationRules('create-student', $_POST);

        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
            dd($errors);
        } else {
            if ($this->studentsModel->getStudentByEmail($_POST['email'])) {
                $this->session->set('form-errors', $this->error('Un autre élève possède le même email'));
            } elseif ($this->studentsModel->getStudentByPhone($_POST['phone'])) {
                $this->session->set('form-errors', $this->error('Un autre élève possède le même numéro de téléphone'));
            } elseif (!$this->niveauxModel->niveauIdExists((int) $_POST['niveauId'])) {
                $this->session->set('form-errors', $this->error('La niveau sélectionné n\'existe pas'));
            } elseif (!$this->classesModel->classeIdExists((int) $_POST['classeId'])) {
                $this->session->set('form-errors', $this->error('La classe sélectionnée n\'existe pas'));
            } elseif (!$this->classesModel->classeNiveauMatch((int) $_POST['classeId'], (int) $_POST['niveauId'])) {
                $this->session->set('form-errors', $this->error('Le niveau ne correspond pas à la classe sélectionnée'));
            } else {
                $this->studentsModel->saveStudent($_POST);
                $this->session->set('msg', $this->success('Elève créé avec succès'));
            }
        }

        $this->redirect($_POST['current-url'], false);
    }
}
