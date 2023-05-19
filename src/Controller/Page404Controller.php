<?php

namespace App\Controller;

use App\Controller;

class Page404Controller extends Controller
{
    public function index()
    {
        echo $this->render('404');
    }
}