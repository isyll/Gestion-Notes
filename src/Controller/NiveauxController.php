<?php

namespace App\Controller;

use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use Core\Controller;
use Core\Database;
use Core\FormValidator;
use Core\Helpers;

class NiveauxController extends Controller
{
    private NiveauxModel $model;

    private ClassesModel $cmodel;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->model  = new NiveauxModel($db);
        $this->cmodel = new ClassesModel($db);
    }

    public function index(string $niveau = NULL)
    {
        // $this->data['current'] = 'niveaux';
        // $this->data['title']   = 'Niveaux';
        // $this->data['niveaux'] = $this->model->getAll();

        // if ($this->request['method'] === 'POST') {

        // } else {
        //     if (isset($niveau) && is_numeric($niveau)) {
        //         $this->data['requested'] = $this->model->getNiveauById((int) $niveau);
        //         if (count($this->data['requested'])) {
        //             $this->data['classes'] = $this->model->getClasses($niveau);
        //         } else {
        //             echo 'dsdsdsl';
        //             $this->data['classes'] = [];
        //         }
        //     }
        // }

        // echo $this->render('niveaux', $this->data);
    }

    public function getNiveaux(string $period = NULL)
    {
        $this->data['current'] = 'niveaux';
        $this->data['title']   = 'Niveaux';
        $this->data['period']  = $period;

        if ($period) {
            $this->data['niveaux'] = $this->model->getSYNiveauxByPeriod($period);

            if (count($this->data['niveaux']) === 0) {
                $this->data['exists'] = false;
                $this->data['msg'] = Helpers::msg("L'année scolaire {$period} n'existe pas", 'danger');
            } else {
                $this->data['exists'] = true;
            }
        }

        echo $this->render('niveaux', $this->data);
    }

    public function createNiveau()
    {
        $fv = new FormValidator([
            [
                'required' => true,
                'name' => 'libellé de niveau',
                'value' => $_POST['libelleNiveau'] ?? '',
            ],
            [
                'required' => true,
                'name' => 'libellé de classe',
                'value' => $_POST['idPeriode'],
            ]
        ]);

        $fv->validate();

        // if (count($this->data['errors'] = $fv->getErrors()) > 0) {
        //     $this->data['msg'] = Helpers::msg('Formulaire invalide', 'danger');
        // } else {
        //     if ($this->model->niveauExist($_POST['libelleNiveau'])) {
        //         $this->data['msg'] = Helpers::msg('Ce niveau déjà', 'danger');
        //     } else {
        //         $this->model->saveNiveau([
        //             'libelle' => $_POST['libelleNiveau']
        //         ]);
        //         $this->data['msg']     = Helpers::msg('Année créée avec succès');
        //         $this->data['niveaux'] = $this->model->getNiveaux();
        //     }
        // }
    }
}
