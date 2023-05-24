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
        $this->data['current'] = 'school-years';
        $this->data['title']   = 'Année scolaire';

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

        $fv = new FormValidator(
            [
                [
                    'value' => $_POST['period'],
                    'name' => 'libellé',
                    'regex' => '/^\d{4}-\d{4}$/',
                    'required' => true
                ]
            ]
        );

        $fv->validate();
        $years = explode('-', $_POST['period']);

        if (
            count($this->data['errors'] = $fv->getErrors()) > 0 ||
            !is_numeric($years[0]) || !is_numeric($years[1]) ||
            $years[1] - $years[0] !== 1
        ) {
            $this->session->set(
                'year-create-msg',
                Helpers::msg('Année non valide', 'danger')
            );
        } else if ($this->model->periodExist($_POST['period'])) {
            $this->session->set(
                'year-create-msg',
                Helpers::msg('Année déjà existante', 'danger')
            );
        } else {
            $this->model->saveYear([
                'period' => $_POST['period']
            ]);

            $this->session->set(
                'year-create-msg',
                Helpers::msg('Année créée avec succès')
            );
        }

        $this->redirect($this->data['urls']['school-years']);
    }

    public function removeYear()
    {
        $this->session->set('year-remove', true);

        $fv = new FormValidator(
            [
                [
                    'value' => $_POST['yearId'],
                    'type' => 'numeric',
                    'name' => 'id',
                    'required' => true
                ]
            ]
        );

        $fv->validate();

        if (
            count($this->data['errors'] = $fv->getErrors()) > 0
        ) {
            $this->session->set(
                'year-remove-msg',
                Helpers::msg('Année non valide', 'danger')
            );
        } else if (!$this->model->yearExist((int) $_POST['yearId'])) {
            $this->session->set(
                'year-remove-msg',
                Helpers::msg("L'année demandée n'existe pas", 'danger')
            );
        } else {
            $period = $this->model->getYearById((int) $_POST['yearId']);
            $this->model->deleteYear((int) $_POST['yearId']);

            $this->session->set(
                'year-remove-msg',
                Helpers::msg("Année {$period['periode']} supprimée avec succès")
            );
        }

        $this->redirect($this->data['urls']['school-years']);
    }

    public function updateYear()
    {
        $this->session->set('year-update', true);

        $id       = (int) $_POST['yearId'] ?? '';
        $newValue = $_POST['newValue'] ?? '';

        $this->fv->form([
            [
                'required' => true,
                'value' => $id,
                'name' => 'yearId',
                'type' => 'numeric',
                'error_msg' => "L'id $id est invalide"
            ],
            [
                'required' => true,
                'name' => 'yearNewValue',
                'value' => $newValue,
                'regex' => '/\d{4}-\d{4}/',
                'error_msg' => "La période $newValue est invalide"
            ],
        ]);

        $this->fv->validate();
        $years = explode('-', $newValue);

        if (
            count($errors = $this->fv->getErrors()) > 0 ||
            $years[1] - $years[0] !== 1
        ) {
            $this->session->set(
                'year-update-msg',
                Helpers::msg("L'année $newValue est invalide", 'danger')
            );
            $this->session->set(
                'year-update-errors',
                $errors
            );
        } else if ($this->model->yearExist($id)) {
            if ($this->model->updateYear($id, $newValue)) {
                $this->session->set(
                    'year-update-msg',
                    Helpers::msg('Année modifiée avec succès')
                );
            } else {
                $this->session->set(
                    'year-update-msg',
                    Helpers::msg("La modification n'a pas pu s'effectuer", 'danger')
                );
            }

        } else {
            $this->session->set(
                'year-update-msg',
                Helpers::msg('Année inexistante', 'danger')
            );
        }

        $this->redirect($this->data['urls']['school-years']);
    }

    public function changeYearState()
    {
        $this->session->set('year-state-change', true);

        $id     = (int) $_POST['yearId'];
        $action = $_POST['action'] ?? '';

        if ($this->model->yearExist($id)) {
            if ($action === '')
                $action = 'disable';

            if (!in_array($action, ['active', 'disable'])) {
                $this->session->set(
                    'year-state-change-msg',
                    $this->error("Action impossible")
                );
            } else {
                $action = ['disable' => 0, 'active' => 1][$action];

                if ($this->model->changeState($id, $action)) {
                    $this->session->set(
                        'year-state-change-msg',
                        $this->success('Changement effectué avec succès')
                    );
                } else {
                    $this->session->set(
                        'year-state-change-msg',
                        $this->error("Désolé une erreur est survenue, le changement n'a pas pus s'effectuer")
                    );
                }

            }
        } else {
            $this->session->set(
                'year-state-change-msg',
                $this->error("L'année choisie n'existe pas")
            );
        }

        $this->redirect($this->data['urls']['school-years']);
    }
}
