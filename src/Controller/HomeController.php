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
    }

    public function page404()
    {
        echo "page 404";
    }
}
