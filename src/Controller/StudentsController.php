<?php

namespace App\Controller;

use Core\Controller;
use Core\Router;

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
        if ($niveauId && $classeId) {
            $niveauId = (int) $niveauId;
            $classeId = (int) $classeId;

            if ($this->niveauxModel->hasClasseId($niveauId, $classeId)) {
                $this->data['niveau']   = $this->niveauxModel->getNiveauById($niveauId);
                $this->data['classe']   = $this->classesModel->getClasseById($classeId);
                $this->data['students'] = $this->classesModel->getStudents($classeId);
            } else
                Router::pageNotFound();
        } else
            Router::pageNotFound();

        echo $this->render('students', $this->data);
    }

    public function newStudent($niveauId, $classeId)
    {
        if ($niveauId && $classeId) {
            $niveauId = (int) $niveauId;
            $classeId = (int) $classeId;

            if ($this->niveauxModel->hasClasseId($niveauId, $classeId)) {
                $this->data['niveau']   = $this->niveauxModel->getNiveauById($niveauId);
                $this->data['classe']   = $this->classesModel->getClasseById($classeId);
                $this->data['students'] = $this->classesModel->getStudents($classeId);
            } else
                Router::pageNotFound();
        } else
            Router::pageNotFound();

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
        } else {
            if ($_POST['email'] && $this->studentsModel->getStudentByEmail($_POST['email'])) {
                $this->session->set('msg', $this->error('Un autre élève possède le même email'));
            } elseif ($_POST['phone'] && $this->studentsModel->getStudentByPhone($_POST['phone'])) {
                $this->session->set('msg', $this->error('Un autre élève possède le même numéro de téléphone'));
            } elseif (!$this->niveauxModel->niveauIdExists((int) $_POST['niveauId'])) {
                $this->session->set('msg', $this->error('La niveau sélectionné n\'existe pas'));
            } elseif (!$this->classesModel->classeIdExists((int) $_POST['classeId'])) {
                $this->session->set('msg', $this->error('La classe sélectionnée n\'existe pas'));
            } elseif (!$this->classesModel->classeNiveauMatch((int) $_POST['classeId'], (int) $_POST['niveauId'])) {
                $this->session->set('msg', $this->error('Le niveau ne correspond pas à la classe sélectionnée'));
            } else {
                $_POST['annee_scolaire_id'] = $this->schoolYearsModel->getYearByLibelle($this->data['currentYear'])['id'];
                $this->studentsModel->saveStudent($_POST);
                $this->session->set('msg', $this->success('Elève créé avec succès'));

                $this->redirect($this->data['urls']['list-students'] . "{$_POST['niveauId']}/{$_POST['classeId']}", false);
            }
        }

        $this->redirect($_POST['current-url'], false);
    }
}
