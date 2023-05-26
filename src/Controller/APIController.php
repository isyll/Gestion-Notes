<?php

namespace App\Controller;

use App\Model\ClassesModel;
use Core\Controller;

class APIController extends Controller
{
    private ClassesModel $cm;

    public function __construct()
    {
        parent::__construct();
        $this->cm = new ClassesModel($this->db);
    }

    public function getAllClasses()
    {

    }

    public function getClasses($niveauId)
    {
        if (is_numeric(($niveauId))) {
            try {
                $niveauId = (int) $niveauId;
                $classes  = $this->cm->getClassesByNiveau($niveauId);

                if (count($classes) === 0) {
                    $code = '204';
                    $msg  = 'Aucune classe trouvée pour ce niveau';
                } else {
                    $code = '200';
                    $msg  = 'Traitement effectué';
                }
            }
            catch (\Exception $e) {
                $classes = [];
                $code    = '400';
                $msg     = 'Erreur dans la requête';
            }
        } else {
            $classes = [];
            $code    = '404';
            $msg     = 'Aucune classe trouvée pour ce niveau';
        }

        echo $this->jsonResponse($code, $msg, $classes);
    }
}
