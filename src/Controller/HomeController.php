<?php

namespace App\Controller;

use Core\Controller;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function index()
    {
        $this->data['current'] = 'home';
        echo $this->render('home', $this->data);
    }

    public function page404()
    {
        echo $this->render('404');
    }

    public function test($period = NULL, $niveauSlug = NULL, $classeSlug = NULL)
    {
        echo "test ok";
    }
}
