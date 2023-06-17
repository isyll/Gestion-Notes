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

    public function getStudentsNotes()
    {
        $datas = $this->jsonDecode();
        $this->loadValidationRules('filter-notes', $datas);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $result = [
                'status' => 'fail',
                'msg' => 'Formulaire invalide',
                'errors' => $errors
            ];
        } else {
            $datas['yearId'] = (int) $this->data['yearInfos']['id'];
            $datas['nom_type'] = $datas['noteType'];

            $d['notes'] = $this->notesModel->filterNotes($datas);
            $d['max_note']    = $this->subjectsModel->getClasseSubjectMax($datas);
            $d['cde']   = $this->studentsModel->getCDE($datas);

            $result = [
                'status' => 'done',
                'msg' => '',
                'datas' => $d
            ];
        }

        $this->jsonResponse($result);
    }

    public function getClasseDiscipline()
    {
        $datas = $this->jsonDecode();
        $this->loadValidationRules('cd', $datas);
        $this->fv->validate();

        if ($errors = $this->fv->getErrors()) {
            $result = [
                'status' => 'fail',
                'msg' => 'Formulaire invalide',
                'errors' => $errors
            ];
        } else {
            $datas['yearId'] = (int) $this->data['yearInfos']['id'];

            $result = [
                'status' => 'done',
                'msg' => 'test',
                'datas' => $this->subjectsModel->getClasseDiscipline($datas)
            ];

        }

        $this->jsonResponse($result);
    }

    public function updateStudentNotes()
    {
        $datas  = $this->jsonDecode();
        $result = [];

        foreach ($datas as $d) {
            if (
                array_key_exists('e_id', $d) &&
                array_key_exists('note_type', $d) &&
                array_key_exists('cycle', $d) &&
                array_key_exists('note', $d)
            ) {
                $d['yearId'] = (int) $this->data['yearInfos']['id'];

                if ($this->notesModel->getStudentNote($d))
                    $this->notesModel->updateStudentNotes($d);
                else
                    $this->notesModel->insertStudentNotes($d);

                $result = [
                    'status' => 'done',
                    'msg' => 'Les données ont été sauvegardées',
                ];
            }
        }

        $this->jsonResponse($result);
    }

    public function removeSubjectToStudent()
    {
        $datas  = $this->jsonDecode();
        $result = [];

        if (
            array_key_exists('e_id', $datas) &&
            array_key_exists('subjectId', $datas) &&
            array_key_exists('classeId', $datas)
        ) {
            $datas['yearId'] = (int) $this->data['yearInfos']['id'];

            $this->studentsModel->removeSubjectToStudent($datas);
        }

        $this->jsonResponse($result);
    }

    public function restoreSubjectToStudent()
    {
        $datas  = $this->jsonDecode();
        $result = [];

        if (
            array_key_exists('e_id', $datas) &&
            array_key_exists('subjectId', $datas) &&
            array_key_exists('classeId', $datas)
        ) {
            $datas['yearId'] = (int) $this->data['yearInfos']['id'];

            $this->studentsModel->restoreSubjectToStudent($datas);
        }

        $this->jsonResponse($result);
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

        if ($datas) {
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
            } else {
                if (array_key_exists('coefs', $datas)) {
                    foreach ($datas['coefs'] as $sbjCode => $maxNotes) {
                        $sbj = $this->subjectsModel->getSubjectByCode($sbjCode);

                        if ($sbj) {
                            foreach ($maxNotes as $type => $note) {
                                if (!is_numeric($note)) {
                                    $result['errors'][$sbjCode][] = [
                                        'typeMax' => $type,
                                        'msg' => "Le note maximale $note est invalide"
                                    ];
                                } elseif ($note < 10) {
                                    $result['errors'][$sbjCode][] = [
                                        'typeMax' => $type,
                                        'msg' => "Le note maximale doit être supérieure à 10"
                                    ];
                                } else {
                                    $data = [
                                        'max_note' => $note,
                                        'nom_type' => $type,
                                        'subjectId' => $sbj['id'],
                                        'classeId' => $datas['classeId'],
                                        'yearId' => $this->data['yearInfos']['id']
                                    ];

                                    if ($this->subjectsModel->getClasseSubjectMax($data))
                                        $this->subjectsModel->updateClasseSubjectMax($data);
                                    else
                                        $this->subjectsModel->insertClasseSubjectMax($data);
                                }
                            }
                        } else
                            ;
                    }

                    $err = isset($result['errors']);

                    $result['status'] = $err ? 'fail' : 'done';
                    $result['msg']    = $err ?
                        "Erreurs de validation" :
                        "Les données ont été bien mises à jour";
                } else
                    $result = [
                        'status' => 'fail',
                        'msg' => "Les données envoyées sont invalides",
                    ];
            }

            $this->jsonResponse($result);
        }
    }
}
