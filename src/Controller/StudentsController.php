<?php

namespace App\Controller;

use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use App\Model\StudentsModel;
use Core\Controller;
use Core\Database;
use Core\FormValidator;
use Core\Helpers;

class StudentsController extends Controller
{
    private StudentsModel $model;
    private NiveauxModel $nmodel;
    private ClassesModel $cmodel;

    public function __construct(Database $db)
    {
        parent::__construct($db);

        $this->model  = new StudentsModel($db);
        $this->nmodel = new NiveauxModel($db);
        $this->cmodel = new ClassesModel($db);
    }

    public function index(string $classeId)
    {
        $this->data['current'] = 'students';
        $this->data['title']   = 'Elèves';

        $this->data['classeName'] = $this->cmodel->getName((int) $classeId)[0]["libelle"] ?? '';

        if ($this->data['classeName'] === '') {
            $this->data['msg']    = Helpers::msg("Cette classe n'existe pas", 'danger');
            $this->data['exists'] = false;
        } else {
            $this->data['exists'] = true;

            if ($this->request['method'] === 'POST') {
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
            } else {
            }
        }

        echo $this->render('students', $this->data);
    }
}
