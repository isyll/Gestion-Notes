<?php

namespace App\Controller;

use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use App\Model\SchoolYearsModel;
use Core\Controller;
use Core\Database;
use Core\FormValidator;
use Core\Helpers;

class ClassesController extends Controller
{
    private ClassesModel $model;
    private NiveauxModel $nm;
    private SchoolYearsModel $sym;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->model = new ClassesModel($db);
        $this->nm    = new NiveauxModel($db);
        $this->sym   = new SchoolYearsModel($db);
    }

    public function index(string $id)
    {
        $this->data['current']   = 'niveaux';
        $r                       = $this->nm->getNiveauById((int) $id);
        $this->data['requested'] = [
            'id' => $r[0]['id'],
            'libelle' => $r[0]['libelle'],
        ];
        $this->data['exists']    = count($this->data['requested']) > 0;

        if ($this->request['method'] === 'POST') {
            $fv = new FormValidator([
                [
                    'required' => true,
                    'name' => 'libellé',
                    'value' => $_POST['libelleClasse'] ?? '',
                ]
            ]);

            $fv->validate();

            if (count($this->data['errors'] = $fv->getErrors()) > 0) {
                $this->data['msg'] = Helpers::msg('Formulaire invalide', 'danger');
            } else {
                $this->data['classes'] = $this->nm->getClasses((int) $_POST['niveauId']);
                if ($this->model->classeExist((int) $_POST['niveauId'], $_POST['libelleClasse'])) {
                    $this->data['msg'] = Helpers::msg('Ce niveau possède déjà une classe nommée ' . $_POST['libelleClasse'], 'danger');
                } else if ($this->nm->niveauExist((int) $_POST['niveauId'])) {
                    $this->data['msg'] = Helpers::msg('Le niveau est incorrect', 'danger');
                } else {
                    $this->model->saveClasse($_POST);
                    $this->data['msg']     = Helpers::msg('Classe créée avec succès');
                    $this->data['classes'] = $this->nm->getClasses((int) $_POST['niveauId']);
                }
            }
        } else {
            if ($this->data['exists']) {
                $this->data['classes'] = $this->nm->getClasses((int) $id);
            } else {
                $this->data['msg'] = Helpers::msg("Ce niveau n'existe pas", 'danger');
            }
        }

        echo $this->render('classes', $this->data);
    }

    public function getClasses($period = NULL, $niveauSlug = NULL)
    {
        $this->data['period']     = $period;
        $this->data['niveauSlug'] = $niveauSlug;

        if ($this->sym->yearExistPeriod($period)) {
            if ($this->sym->containsNiveau($period, $niveauSlug)) {
                $this->data['classes'] = $this->model->getClasses($period, $niveauSlug);
                if (count($this->data['classes']) === 0) {
                    $this->data['msg'] = Helpers::msg("Le niveau $niveauSlug ne possède aucune classe", 'danger');
                }
            } else {
                $this->data['msg'] = Helpers::msg("L'année $period ne possède pas de niveau $niveauSlug");
            }
        } else {
            $this->data['msg'] = Helpers::msg("L'année $period n'existe pas.");
        }

        echo $this->render('classes', $this->data);
    }

    public function createClasse()
    {
        $fv = new FormValidator([
            [
                'required' => true,
                'name' => 'libelleNiveau',
                'value' => $_POST['libelleNiveau'] ?? '',
            ],
            [
                'required' => true,
                'name' => 'libelleClasse',
                'value' => $_POST['libelleClasse'] ?? '',
            ],
        ]);

        $fv->validate();

        if (count($this->data['errors'] = $fv->getErrors()) > 0) {
            $this->data['msg'] = Helpers::msg('Formulaire invalide', 'danger');
        } else {
            // if ($this->model->classeExist((int) $_POST['niveauId'], $_POST['libelleClasse'])) {
            //     $this->data['msg'] = Helpers::msg('Ce niveau possède déjà une classe nommée ' . $_POST['libelleClasse'], 'danger');
            // } else {
            //     $this->model->saveClasse($_POST);
            //     $this->data['msg']     = Helpers::msg('Classe créée avec succès');
            // }
        }
    }
}
