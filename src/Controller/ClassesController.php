<?php

namespace App\Controller;

use App\BaseController;
use Core\Router;

class ClassesController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getClasses($niveauId = NULL)
    {
        $this->data['niveauId'] = (int) $niveauId;

        if ($this->niveauxModel->niveauIdExists($this->data['niveauId'])) {
            $this->data['niveau']  = $this->niveauxModel->getNiveauById($this->data['niveauId']);
            $this->data['classes'] = $this->niveauxModel->getClasses($this->data['niveauId']);

            $this->data['classes'] = array_map(function ($item) {
                $item['noteTypes'] = $this->classesModel->getClasseNoteTypes($item['id']);
                return $item;
            }, $this->data['classes']);
        } else
            Router::pageNotFound();

        echo $this->render('classes', $this->data, scripts: ['classes']);
    }

    public function createClasse()
    {
        $this->loadValidationRules('create-classe', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if ($this->niveauxModel->hasClasseLibelle((int) $_POST['niveauId'], $_POST['classeLibelle'])) {
                $this->session->set('msg', $this->error('Ce niveau possède déjà une classe nommée ' . $_POST['classeLibelle']));
            } else {
                if ($this->classesModel->saveClasse($_POST['classeLibelle'], (int) $_POST['niveauId'])) {
                    $this->session->set('msg', $this->success("La classe {$_POST['classeLibelle']} a été créée avec succès"));
                    $this->redirect($this->data['urls']['list-classes'] . $_POST['niveauId'], false);
                } else {
                    $this->session->set('msg', $this->error('Une erreur est survenue lors de la création de la classe ' . $_POST['classeLibelle']));
                }
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function deleteClasse()
    {
        $this->loadValidationRules('delete-classe', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if ($this->classesModel->classeNiveauMatch((int) $_POST['niveauId'], (int) $_POST['classeId'])) {
                if ($this->classesModel->deleteClasse((int) $_POST['niveauId'], (int) $_POST['classeId']))
                    $this->session->set('msg', $this->success('La classe a bien été supprimé'));
                else
                    $this->session->set('msg', $this->error('Une erreur inconnue est survenue lors de la suppression'));
            } else {
                $this->session->set('msg', $this->error('Le niveau sélectionné ne possède pas cette classe'));
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function edit()
    {
        $this->loadValidationRules('edit-classe', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if ($this->niveauxModel->hasClasseId((int) $_POST['niveauId'], (int) $_POST['classeId'])) {
                if ($this->classesModel->editClasse((int) $_POST['classeId'], $_POST['newClasseLibelle']))
                    $this->session->set('msg', $this->success('La classe a bien été modifiée'));
                else
                    $this->session->set('msg', $this->error('Une erreur inconnue est survenue lors de la suppression'));
            } else {
                $this->session->set('msg', $this->error('Les données envoyées sont invalides'));
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }
    public function manage()
    {
        if (
            array_key_exists('noteType', $_POST) &&
            array_key_exists('classeId', $_POST) &&
            is_array($_POST['noteType'])
        ) {
            if ($classe = $this->classesModel->getClasseById($_POST['classeId'])) {
                $types = array_map(function ($item) {
                    return $this->helpers::rmms(strtolower($item['nom_type']));
                }, $this->classesModel->getClasseNoteTypes($classe['id']));

                // removes types wich are not present in the datas
                foreach ($types as $nt) {
                    if (!in_array($nt, $this->helpers->processArray($_POST['noteType'])))
                        $this->classesModel->delNoteType($classe['id'], $nt);
                }

                // add new types
                foreach ($_POST['noteType'] as $nt) {
                    $nt = $this->helpers::rmms(strtolower($nt));

                    if ($nt !== "") {
                        if (!in_array($nt, $types))
                            $this->classesModel->addNoteType($classe['id'], ucwords($nt), $this->data['yearInfos']['id']);
                    }
                }

                $this->session->set('msg', $this->success('Le données ont été enregistrées'));
            } else
                $this->session->set('msg', $this->error("Le niveau sélectionné n'existe pas"));
        } else
            $this->session->set('msg', $this->error('Les données envoyées sont invalides'));

        $this->redirect($_POST['current-url'] ?? '', false);
    }
}
