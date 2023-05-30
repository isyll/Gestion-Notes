<?php

namespace App\Controller;

use Core\Controller;

class SchoolYearsController extends Controller
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
}
