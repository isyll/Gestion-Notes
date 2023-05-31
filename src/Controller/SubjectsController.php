<?php

namespace App\Controller;

use Core\Controller;

class SubjectsController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function page()
    {
        $this->data['niveaux'] = $this->niveauxModel->getNiveaux();

        echo $this->render('subjects', $this->data, NULL, false, ['subjects']);
    }
}
