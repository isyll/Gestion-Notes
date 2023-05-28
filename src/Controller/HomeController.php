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
        echo $this->render(file: '404', layout: false, minify: true);
    }

    public function test()
    {
        echo "test ok";
    }
}
