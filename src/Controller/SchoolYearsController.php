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

            SessionManager::remove('school-create');
            SessionManager::remove('school-create-msg');
        }

        echo $this->render('school-years', $this->data);
    }

    public function createYear(string $year)
    {
        SessionManager::set('school-create', true);

        $this->data['current'] = 'school-years';

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
            SessionManager::set(
                'school-create-msg',
                Helpers::msg('Année créée avec succès', 'success')
            );
            $this->model->saveYear([
                'period' => $_POST['period']
            ]);
        }

        Helpers::redirectSite('/school-years');
    }
}
