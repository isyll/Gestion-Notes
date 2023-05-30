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

                echo $this->render('students', $this->data);
                return;
            }
        }

        Router::pageNotFound();
    }

    public function newStudent($niveauId = NULL, $classeId = NULL)
    {
        if ($niveauId && $classeId) {
            $niveauId = (int) $niveauId;
            $classeId = (int) $classeId;

            if ($this->niveauxModel->hasClasseId($niveauId, $classeId)) {
                $this->data['niveau']   = $this->niveauxModel->getNiveauById($niveauId);
                $this->data['classe']   = $this->classesModel->getClasseById($classeId);
                $this->data['students'] = $this->classesModel->getStudents($classeId);

                echo $this->render('new-student', $this->data);
                return;
            }
        }

        Router::pageNotFound();
    }

    public function studentPage($niveauId = NULL, $classeId = NULL, $studentId = NULL)
    {
        if ($studentId && $niveauId && $classeId) {

            if (
                $this->niveauxModel->hasClasseId($niveauId, $classeId)
                && $this->classesModel->hasStudent($classeId, $studentId)
            ) {
                $this->data['niveau']  = $this->niveauxModel->getNiveauById($niveauId);
                $this->data['classe']  = $this->classesModel->getClasseById($classeId);
                $this->data['student'] = $this->studentsModel->getStudentById($studentId);

                echo $this->render('student-page', $this->data);
                return;
            }
        }

        Router::pageNotFound();
    }

    public function editStudent($niveauId = NULL, $classeId = NULL, $studentId = NULL)
    {
        if ($studentId && $niveauId && $classeId) {
            if (
                $this->niveauxModel->hasClasseId($niveauId, $classeId)
                && $this->classesModel->hasStudent($classeId, $studentId)
            ) {
                $this->data['niveau']  = $this->niveauxModel->getNiveauById($niveauId);
                $this->data['classe']  = $this->classesModel->getClasseById($classeId);
                $this->data['student'] = $this->studentsModel->getStudentById($studentId);

                echo $this->render('edit-student', $this->data);
                return;
            }
        }

        Router::pageNotFound();
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
            } elseif (!$this->niveauxModel->hasClasseId((int) $_POST['niveauId'], (int) $_POST['classeId'])) {
                $this->session->set('msg', $this->error('Les données sont invalides'));
            } else {
                $_POST['yearId'] = $this->schoolYearsModel->getYearByLibelle($this->data['currentYear'])['id'];

                $this->studentsModel->saveStudent($_POST);
                $this->session->set('msg', $this->success('Elève créé avec succès'));

                $this->redirect($this->data['urls']['list-students'] . "{$_POST['niveauId']}/{$_POST['classeId']}", false);
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function edit()
    {
        $this->loadValidationRules('create-student', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors() || empty($_POST['studentId'])) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } elseif (
            !$this->niveauxModel->hasClasseId($_POST['niveauId'], $_POST['classeId'])
            || !$this->classesModel->hasStudent($_POST['classeId'], $_POST['studentId'])
        ) {
            $this->session->set('msg', $this->error('Les données sont invalides'));
        } else {
            $this->studentsModel->deleteStudent($_POST['studentId']);

            if ($_POST['phone'] && $this->studentsModel->getStudentByPhone($_POST['phone'])) {
                $this->session->set('msg', $this->error('Un autre élève possède le même numéro de téléphone'));
            } elseif ($_POST['email'] && $this->studentsModel->getStudentByEmail($_POST['email'])) {
                $this->session->set('msg', $this->error('Un autre élève possède le même email'));
            } else {
                $this->session->set('msg', $this->success('Eléve modifié avec succès'));
                $this->studentsModel->editStudent($_POST['studentId'], $_POST);
            }

            $this->studentsModel->restoreStudent($_POST['studentId']);
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function delete()
    {
        $this->loadValidationRules('delete-student', $_POST);

        $this->fv->validate();

        if ($errors = $this->fv->getErrors() || empty($_POST['studentId'])) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } elseif ($this->studentsModel->getStudentById($_POST['studentId'])) {
            $this->session->set('msg', $this->success('Elève supprimé avec succès'));
            $this->studentsModel->deleteStudent($_POST['studentId']);
        } else {
            $this->session->set('msg', $this->error('Données invalides'));
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }
}
