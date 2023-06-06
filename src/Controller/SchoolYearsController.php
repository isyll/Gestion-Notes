<?php

namespace App\Controller;

use App\BaseController;

class SchoolYearsController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function list()
    {
        $this->data['years'] = $this->schoolYearsModel->getYears();

        echo $this->render('years', $this->data);
    }

    public function createYear()
    {
        $this->loadValidationRules('create-year', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            $years = explode('-', $_POST['libelle']);

            if (
                count($years) !== 2 ||
                !is_numeric($years[0]) ||
                !is_numeric($years[1]) ||
                $years[1] - $years[0] !== 1
            ) {
                $this->session->set('msg', $this->error('Formulaire invalide'));
                $this->session->set('form-errors', ['libelle' => 'Le libellé ne répond pas aux critères']);
            } elseif ($this->schoolYearsModel->yearLibelleExists($_POST['libelle'])) {
                $this->session->set('msg', $this->error('Cette année existe déjà'));
            } else {
                if ($this->schoolYearsModel->saveYear($_POST))
                    $this->session->set('msg', $this->success("L'année a bien été enregistrée"));
                else
                    $this->session->set('msg', $this->error("Une erreur inconnue s'est produite"));
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function edit()
    {
        $this->loadValidationRules('edit-year', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } elseif (!$this->schoolYearsModel->yearIdExists($_POST['yearId'])) {
            $this->session->set('msg', $this->error('Année inexistante'));
        } else {
            $years = explode('-', $_POST['libelle']);

            if (
                count($years) !== 2 ||
                !is_numeric($years[0]) ||
                !is_numeric($years[1]) ||
                $years[1] - $years[0] !== 1
            ) {
                $this->session->set('msg', $this->error('Formulaire invalide'));
                $this->session->set('form-errors', ['libelle' => 'Le libellé ne répond pas aux critères']);
            } else {
                $year = $this->schoolYearsModel->getYearById($_POST['yearId']);
                $this->schoolYearsModel->deleteYearById($_POST['yearId']);

                if ($this->schoolYearsModel->getYearByLibelle($_POST['libelle'])) {
                    $this->session->set('msg', $this->error('Cette année existe déjà'));
                } else {
                    if ($this->schoolYearsModel->editYear($_POST['yearId'], $_POST)) {
                        if ($year['libelle'] === $this->getParam('annee-actuelle')) {
                            $this->updateParam('annee-actuelle', $_POST['libelle']);
                        }

                        $this->session->set('msg', $this->success("L'année a bien été enregistrée"));
                    } else
                        $this->session->set('msg', $this->error("Une erreur inconnue s'est produite"));
                }

                $this->schoolYearsModel->restoreYearById($_POST['yearId']);
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }

    public function deleteYear()
    {
        $this->loadValidationRules('delete-year', $_POST);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $this->session->set('msg', $this->error('Formulaire invalide'));
            $this->session->set('form-errors', $errors);
        } else {
            if (!$this->schoolYearsModel->yearIdExists($_POST['yearId'])) {
                $this->session->set('msg', $this->error("Cette année n'existe pas"));
            } else {
                if ($this->schoolYearsModel->getYearById($_POST['yearId'])['libelle'] === $this->getParam('annee-actuelle')) {
                    $this->session->set('msg', $this->error("Vous ne pouvez pas supprimer l'année courante"));
                } elseif ($this->schoolYearsModel->deleteYearById($_POST['yearId']))
                    $this->session->set('msg', $this->success("L'année a bien été supprimée"));
                else
                    $this->session->set('msg', $this->error("Une erreur inconnue est survenue"));
            }
        }

        $this->redirect($_POST['current-url'] ?? '', false);
    }
}
