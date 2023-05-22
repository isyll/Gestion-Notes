<?php

namespace App\Controller;

use App\Model\ClassesModel;
use App\Model\NiveauxModel;
use Core\Controller;
use Core\Database;
use Core\FormValidator;
use Core\Helpers;

class ClassesController extends Controller
{
    private ClassesModel $model;
    private NiveauxModel $nm;

    public function __construct(Database $db)
    {
        parent::__construct($db);
        $this->model = new ClassesModel($db);
        $this->nm    = new NiveauxModel($db);
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
}
