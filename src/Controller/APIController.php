<?php

namespace App\Controller;

use App\BaseController;
use Core\Helpers;

class APIController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getNiveaux()
    {
        $this->jsonResponse($this->niveauxModel->getNiveaux());
    }

    public function getClassesByNiveauId($niveauId = NULL)
    {
        if (isset($niveauId) && is_numeric($niveauId)) {
            try {
                $niveauId = (int) $niveauId;
                $classes  = $this->classesModel->getClassesByNiveau($niveauId);

                if (count($classes) === 0) {
                    $code = '204';
                } else {
                    $code = '200';
                }
            }
            catch (\Exception $e) {
                $classes = [];
                $code    = '400';
            }
        } else {
            $classes = [];
            $code    = '404';
        }

        $this->jsonResponse($classes, $code);
    }

    public function getClasseSubjects($classeId)
    {
        $data = [];

        if (is_numeric($classeId))
            $data = $this->subjectsModel->getClasseSubjects($classeId);

        $this->jsonResponse($data);
    }

    public function subjectExists($sbjName)
    {
        $exists = $this->subjectsModel->subjectNameExists($sbjName);

        $this->jsonResponse([$exists]);
    }

    public function hasSubject($classeId, $sbjName)
    {
        $exists = $this->subjectsModel->isClasseHasSubject($classeId, $sbjName);

        $this->jsonResponse([$exists]);
    }

    public function getSubjectByCode($code)
    {
        $subject = $this->subjectsModel->getSubjectByCode($code);

        $this->jsonResponse([$subject]);
    }

    public function createSubject()
    {
        $datas = $this->jsonDecode();
        $this->loadValidationRules('create-subject', $datas);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $result = [
                'status' => 'fail',
                'msg' => 'Formulaire invalide',
                'errors' => $errors
            ];
        } elseif (!$this->subjectsModel->getGroupById($datas['groupId'])) {
            $result = [
                'status' => 'fail',
                'msg' => "Le groupe sélectionné n'existe pas",
            ];
        } else {
            if ($this->subjectsModel->saveSubject($datas))
                $result = [
                    'status' => 'done',
                    'msg' => 'Discipline créée avec succès'
                ];
            else
                $result = [
                    'status' => 'fail',
                    'msg' => 'Une erreur inconnue est survenue'
                ];
        }

        $this->jsonResponse($result);
    }

    public function updateClasseSubjects()
    {
        $datas = $this->jsonDecode();

        $this->loadValidationRules('update-classe-subjects', $datas);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $result = [
                'status' => 'fail',
                'msg' => 'Formulaire invalide',
                'errors' => $errors
            ];
        } elseif (!$this->classesModel->getClasseById($datas['classeId'])) {
            $result = [
                'status' => 'fail',
                'msg' => "La classe sélectionné n'existe pas",
            ];
        } elseif (!array_key_exists('add', $datas) || !array_key_exists('del', $datas)) {
            $result = [
                'status' => 'fail',
                'msg' => 'Les données envoyées sont invalides',
            ];
        } else {
            $exists = true;
            $sbjs   = array_merge(array_values($datas["add"]), array_values($datas["del"]));

            foreach ($sbjs as $s) {
                if (!$this->subjectsModel->getSubjectByName($s)) {
                    $exists        = false;
                    $result['msg'] = "La discipline $s est inexistante";
                    break;
                }
            }

            if ($exists) {
                foreach ($datas['add'] as $val) {
                    $sbj = $this->subjectsModel->getSubjectByName($val);
                    $this->subjectsModel->addSubjectToClasse($datas['classeId'], $sbj['id'], $this->data['yearInfos']['id']);
                }
                foreach ($datas['del'] as $val) {
                    $sbj = $this->subjectsModel->getSubjectByName($val);
                    $this->subjectsModel->delSubjectFromClasse($datas['classeId'], $sbj['id'], $this->data['yearInfos']['id']);
                }

                $result = [
                    'status' => 'done',
                    'msg' => "Les disciplines ont été bien mises à jour",
                ];
            } else
                $result['status'] = 'fail';
        }

        $this->jsonResponse($result);
    }

    public function updateCoefs()
    {
        $datas = $this->jsonDecode();
        $this->loadValidationRules('update-coefs', $datas);

        if ($errors = $this->fv->getErrors()) {
            $result = [
                'status' => 'fail',
                'msg' => 'Formulaire invalide',
                'errors' => $errors
            ];
        } elseif (!$this->classesModel->getClasseById($datas['classeId'])) {
            $result = [
                'status' => 'fail',
                'msg' => "La classe sélectionné n'existe pas",
            ];
        } elseif (empty($datas['coefs'])) {
            $result = [
                'status' => 'fail',
                'msg' => "Les données envoyées sont invalides",
            ];
        } else {
            $exists = true;

            foreach ($datas['coefs'] as $key => $val) {
                if (!$this->subjectsModel->getSubjectByCode($key)) {
                    $exists        = false;
                    $result['msg'] = "La discipline $key est inexistante";
                    break;
                }
            }

            if ($exists) {
                foreach ($datas['coefs'] as $key => $val) {
                    $sbj = $this->subjectsModel->getSubjectByCode($key);

                    foreach ($val as $type => $i) {
                        if (Helpers::rmms($i) !== '')
                            if (!is_numeric($i)) {
                                $result['errors'][$key][] = [
                                    'typeMax' => $type,
                                    'msg' => "Le note maximale $i est invalide"
                                ];
                            } elseif ($i < 10) {
                                $result['errors'][$key][] = [
                                    'typeMax' => $type,
                                    'msg' => "Le note maximale doit être supérieure à 10"
                                ];
                            } elseif (in_array($type, ['max_ressource', 'max_examen'])) {
                                $this->subjectsModel->updateClasseSubjectMax(
                                    [
                                        $type => $i,
                                        'subjectId' => $sbj['id'],
                                        'classeId' => $datas['classeId'],
                                        'yearId' => $this->data['yearInfos']['id']
                                    ],
                                    $type
                                );
                            }
                    }
                }

                $result['status'] = isset($result['errors']) ? 'fail' : 'done';
                $result['msg']    = isset($result['errors']) ?
                    "Erreurs de validation" :
                    "Les coefficients ont été bien mises à jour";
            } else
                $result['status'] = 'fail';
        }

        $this->jsonResponse($result);
    }
}
