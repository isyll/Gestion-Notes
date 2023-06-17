<?php

namespace App\Controller;

use App\BaseController;

class HomeController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function page404()
    {
        echo $this->render('404', $this->data, false, true);
    }

    public function initPage()
    {
        echo $this->render('initpage', $this->data);
    }

    public function test()
    {
        // $niveaux = $this->niveauxModel->getNiveaux();
        // foreach ($niveaux as $n) {
        //     $classes = $this->classesModel->getClassesByNiveau($n['id']);

        //     foreach ($classes as $c) {
        //         $subjects  = $this->subjectsModel->getClasseSubjects($c['id']);
        //         $noteTypes = $this->classesModel->getClasseNoteTypes($c['id']);

        //         foreach ($subjects as $sbj) {
        //             foreach ($noteTypes as $nt) {

        //                 $this->subjectsModel->insertClasseSubjectMax([
        //                     'max_note' => 0,
        //                     'nom_type' => $nt['nom_type'],
        //                     'classeId' => $c['id'],
        //                     'subjectId' => $sbj['id'],
        //                     'yearId' => $this->data['yearInfos']['id']
        //                 ]);
        //             }
        //         }
        //     }
        // }
    }
}
