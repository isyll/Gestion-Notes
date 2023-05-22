<?php

namespace App\Controller;

use App\Model\NiveauxModel;
use Core\Controller;
use Core\Database;
use Core\FormValidator;
use Core\Helpers;

class NiveauxController extends Controller
{
    private NiveauxModel $model;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->model = new NiveauxModel($db);
    }

    public function index(string $niveau = NULL)
    {
        $this->data['current'] = 'niveaux';
        $this->data['title']   = 'Niveaux';
        $this->data['niveaux'] = $this->model->getAll();

        if ($this->request['method'] === 'POST') {
            if (isset($_POST['libelleNiveau'])) {
                $fv = new FormValidator([
                    [
                        'required' => true,
                        'name' => 'libelleNiveau',
                        'value' => $_POST['libelleNiveau'] ?? '',
                    ]
                ]);

                $fv->validate();

                if (count($this->data['errors'] = $fv->getErrors()) > 0) {
                    $this->data['msg'] = Helpers::msg('Formulaire invalide', 'danger');
                } else {
                    if ($this->model->niveauExist($_POST['libelleNiveau'])) {
                        $this->data['msg'] = Helpers::msg('Ce niveau déjà', 'danger');
                    } else {
                        $this->model->saveNiveau([
                            'libelle' => $_POST['libelleNiveau']
                        ]);
                        $this->data['msg']     = Helpers::msg('Année créée avec succès');
                        $this->data['niveaux'] = $this->model->getNiveaux();
                    }
                }
            } else if (isset($_POST['libelleClasse'])) {
                $fv = new FormValidator([
                    [
                        'required' => true,
                        'name' => 'libelleClasse',
                        'value' => $_POST['libelleClasse'] ?? '',
                    ]
                ]);

                $fv->validate();

                if (count($this->data['errors'] = $fv->getErrors()) > 0) {
                    $this->data['msg'] = Helpers::msg('Formulaire invalide', 'danger');
                } else {
                    if ($this->model->classeExist((int) $_POST['niveauId'], $_POST['libelleClasse'])) {
                        $this->data['msg'] = Helpers::msg('Ce niveau possède déjà une classe nommée ' . $_POST['libelleClasse'], 'danger');
                    } else {
                        $this->model->saveClasse($_POST);
                        $this->data['msg']     = Helpers::msg('Classe créée avec succès');
                        $this->data['classes'] = $this->model->getClasses((int) $_POST['niveauId']);
                    }
                }
            }

        } else {

            if (isset($niveau) && is_numeric($niveau)) {
                $this->data['requested'] = $this->model->getNiveauById((int) $niveau);
                if (count($this->data['requested'])) {
                    $this->data['classes'] = $this->model->getClasses($niveau);
                } else {
                    echo 'dsdsdsl';
                    $this->data['classes'] = [];
                }
            }
        }

        echo $this->render('niveaux', $this->data);
    }
}
