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
        // dd($this->studentsModel->getStudentNiveau(29));
    }
}