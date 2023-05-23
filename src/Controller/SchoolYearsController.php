<?php

namespace App\Controller;

use App\Model\AdminModel;
use App\Model\SchoolYearsModel;
use Core\Controller;
use Core\Database;
use Core\FormValidator;
use Core\Helpers;
use Core\SessionManager;

class SchoolYearsController extends Controller
{
    private SchoolYearsModel $model;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->model = new SchoolYearsModel($db);
    }

    public function index()
    {
        $this->data['current'] = 'school-years';
        $this->data['title']   = 'Année scolaire';

        $this->data['schoolYears'] = $this->model->getYears();

        if (SessionManager::get('school-create')) {
            $this->data['msg'] = SessionManager::get('school-create-msg');

            SessionManager::remove(['school-create', 'school-create-msg']);
        } else if (SessionManager::get('school-remove')) {
            $this->data['msg'] = SessionManager::get('school-remove-msg');

            SessionManager::remove(['school-remove', 'school-remove-msg']);
        }

        echo $this->render('school-years', $this->data);
    }

    public function createYear()
    {
        SessionManager::set('school-create', true);

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
            SessionManager::set(
                'school-create-msg',
                Helpers::msg('Année non valide', 'danger')
            );
        } else if ($this->model->periodExist($_POST['period'])) {
            SessionManager::set(
                'school-create-msg',
                Helpers::msg('Année déjà existante', 'danger')
            );
        } else {
            $this->model->saveYear([
                'period' => $_POST['period']
            ]);

            SessionManager::set(
                'school-create-msg',
                Helpers::msg('Année créée avec succès')
            );
        }

        Helpers::redirectSite('/school-years');
    }

    public function removeYear()
    {
        SessionManager::set('school-remove', true);

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
            SessionManager::set(
                'school-remove-msg',
                Helpers::msg('Année non valide', 'danger')
            );
        } else if (!$this->model->yearExist((int) $_POST['yearId'])) {
            SessionManager::set(
                'school-remove-msg',
                Helpers::msg("L'année demandée n'existe pas", 'danger')
            );
        } else {
            $period = $this->model->getYearById((int) $_POST['yearId']);
            $this->model->deleteYear((int) $_POST['yearId']);

            SessionManager::set(
                'school-remove-msg',
                Helpers::msg("Année {$period['periode']} supprimée avec succès")
            );
        }

        Helpers::redirectSite('/school-years');
    }
}
