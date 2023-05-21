<?php

namespace App\Controller;

use App\Model\AdminModel;
use App\Model\SchoolYearsModel;
use Core\Controller;
use Core\Database;
use Core\FormValidator;
use Core\Helpers;

class SchoolYearsController extends Controller
{
    private SchoolYearsModel $model;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->model = new SchoolYearsModel($db);
    }

    public function schoolYears(string $period)
    {
        $this->data['schoolYears'] = $this->model->getYears();

        $y = ((int) date('Y')) - 5;
        for ($i = $y; $i < $y + 15; $i++) {
            $i2                      = $i + 1;
            $this->data['periods'][] = "$i - $i2";
        }

        if ($this->request['method'] === 'POST') {
            $_POST['period'] = Helpers::rms($_POST['period']);

            $fv = new FormValidator([
                [
                    'name' => 'period',
                    'required' => true,
                    'value' => $_POST['period'] ?? '',
                    'regex' => '/^[0-9]{4}\s?-\s?[0-9]{4}$/',
                ]
            ]);

            $fv->validate();

            if (count($this->data['errors'] = $fv->getErrors()) > 0) {
                $this->data['msg'] = Helpers::msg('Formulaire invalide', 'danger');
            } else {
                if ($this->model->periodExist($_POST['period'])) {
                    $this->data['msg'] = Helpers::msg('Année déjà existante', 'danger');
                } else {
                    $this->model->saveYear([
                        'period' => $_POST['period']
                    ]);
                    $this->data['msg'] = Helpers::msg('Année créée avec succès');
                    $this->data['schoolYears'] = $this->model->getYears();
                }

            }
        } else {
            if ($period !== '') {
                if (!$this->model->periodExist($period))
                    $this->data['msg'] = Helpers::msg("L'année $period n'existe pas!", 'danger');
            }
        }

        echo $this->render('admin', $this->data);
    }
}
