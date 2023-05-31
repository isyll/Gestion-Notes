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
        echo $this->render('subjects', $this->data);
    }
}
