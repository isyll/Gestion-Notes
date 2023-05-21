<?php

namespace App\Controller;

use Core\Controller;
use Core\Database;
use Core\Router;

class HomeController extends Controller
{
    private Router $router;

    public function __construct(Database $db)
    {
        parent::__construct($db);
    }

    public function index()
    {
        $this->data['current'] = 'home';
        echo $this->render('home', $this->data);
    }

    public function page404()
    {
        echo $this->render('404.html.php');
    }
}
