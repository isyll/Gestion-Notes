<?php

namespace App\Controller;

use Core\Controller;

class APIController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getNiveaux()
    {
        $code = '500';

        if ($data = $this->niveauxModel->getNiveaux())
            $code = '200';

        echo $this->jsonResponse($code, $data);
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

        echo $this->jsonResponse($code, $classes);
    }
}
