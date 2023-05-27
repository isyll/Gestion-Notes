<?php

namespace App\Controller;

use Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function page404()
    {
        echo $this->render('404');
    }

    public function test()
    {
        echo "test ok";
    }
}
