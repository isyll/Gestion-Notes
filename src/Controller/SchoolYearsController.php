<?php

namespace App\Controller;

use App\Model\SchoolYearsModel;
use Core\Controller;
use Core\FormValidator;
use Core\Helpers;

class SchoolYearsController extends Controller
{
    private SchoolYearsModel $model;

    public function __construct()
    {
        parent::__construct();
        $this->model = new SchoolYearsModel($this->db);
    }

    public function getYears()
    {
        $this->data['current']      = 'school-years';
        $this->data['title']        = 'Année scolaire';
        $this->data['currenntYear'] = $this->getUserData('annee-actuelle');

        $this->data['schoolYears'] = $this->model->getYears();

        if ($this->session->get('year-create')) {
            $this->data['msg'] = $this->session->get('year-create-msg');
            $this->session->remove(['year-create', 'year-create-msg']);

        } else if ($this->session->get('year-remove')) {
            $this->data['msg'] = $this->session->get('year-remove-msg');
            $this->session->remove(['year-remove', 'year-remove-msg']);

        } else if ($this->session->get('year-update')) {
            $this->data['msg'] = $this->session->get('year-update-msg');
            $this->session->remove(['year-update', 'year-update-msg']);

        } else if ($this->session->get('year-state-change')) {
            $this->data['msg'] = $this->session->get('year-state-change-msg');
            $this->session->remove(['year-state-change', 'year-state-change-msg']);

        }

        echo $this->render('school-years', $this->data);
    }

    public function createYear()
    {
        $this->session->set('year-create', true);

        $yearLibelle = $_POST['yearLibelle'] ?? '';

        $this->fv->form(
            [
                [
                    'value' => $yearLibelle,
                    'name' => 'yearLibelle',
                    'regex' => '/^\d{4}-\d{4}$/',
                    'required' => true
                ]
            ]
        );

        $this->fv->validate();
        $years = explode('-', $yearLibelle);

        if (
            $errors = $this->fv->getErrors() ||
            !is_numeric($years[0]) ||
            !is_numeric($years[1]) ||
            $years[1] - $years[0] !== 1
        ) {
            $this->session->set('year-create-errors', $errors);

            $this->session->set(
                'year-create-msg',
                $this->error('Année non valide')
            );
        } else if ($this->model->yearExistsByLibelle($yearLibelle)) {
            $this->session->set(
                'year-create-msg',
                $this->error('Année déjà existante')
            );
        } else {
            $this->model->saveYear($yearLibelle);

            $this->session->set(
                'year-create-msg',
                $this->success('Année créée avec succès')
            );
        }

        $this->redirect($_POST['current-url'] ?? '');
    }

    public function removeYear()
    {
        $this->session->set('year-remove', true);

        $yearLibelle = $_POST['yearLibelle'] ?? '';

        $this->fv->form(
            [
                [
                    'value' => $yearLibelle,
                    'name' => 'yearLibelle',
                    'regex' => '/^\d{4}-\d{4}$/',
                    'required' => true,
                    'error_msg' => "L'année $yearLibelle est invalide"
                ]
            ]
        );

        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('year-remove-errors', $errors);
            $this->session->set(
                'year-remove-msg',
                $this->error('Année non valide')
            );
        } else if (!$this->model->yearExistsByLibelle($yearLibelle)) {
            $this->session->set(
                'year-remove-msg',
                $this->error("L'année demandée n'existe pas")
            );
        } else {
            $this->model->deleteYearByLibelle($yearLibelle);

            $this->session->set(
                'year-remove-msg',
                $this->error("Année $yearLibelle supprimée avec succès")
            );
        }

        $this->redirect($_POST['current-url'] ?? '');
    }

    public function updateYear()
    {
        $this->session->set('year-update', true);

        $oldLibelle = $_POST['oldLibelle'] ?? '';
        $newLibelle = $_POST['newLibelle'] ?? '';

        $this->fv->form([
            [
                'required' => true,
                'value' => $oldLibelle,
                'name' => 'yearLibelle',
                'regex' => '/\d{4}-\d{4}/',
                'error_msg' => "L'année $oldLibelle est invalide"
            ],
            [
                'required' => true,
                'name' => 'newLibelle',
                'value' => $newLibelle,
                'regex' => '/\d{4}-\d{4}/',
                'error_msg' => "L'année $newLibelle est invalide"
            ],
        ]);

        $this->fv->validate();
        $oldYears = explode('-', $oldLibelle);
        $newYears = explode('-', $newLibelle);

        if (
            $errors = $this->fv->getErrors() ||
            !is_numeric($oldYears[0]) ||
            !is_numeric($oldYears[1]) ||
            !is_numeric($newYears[0]) ||
            !is_numeric($newYears[1]) ||
            $oldYears[1] - $oldYears[0] ||
            $newYears[1] - $newYears[0]
        ) {
            $this->session->set(
                'year-update-msg',
                $this->error("Formulaire invalide")
            );
            if ($errors)
                $this->session->set(
                    'year-update-errors',
                    $errors
                );
        } else if ($this->model->yearExistsByLibelle($oldLibelle)) {
            if ($this->model->updateYearByLibelle($oldLibelle, $newLibelle)) {
                $this->session->set(
                    'year-update-msg',
                    $this->success('Année modifiée avec succès')
                );
            } else {
                $this->session->set(
                    'year-update-msg',
                    $this->error("La modification n'a pas pu s'effectuer")
                );
            }

        } else {
            $this->session->set(
                'year-update-msg',
                $this->error('Année inexistante')
            );
        }

        $this->redirect($_POST['current-url'] ?? '');
    }
}
