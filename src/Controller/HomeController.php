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
    $data['title'] = 'Accueil ' . $GLOBALS['siteName'];
    $data['urls']  = Router::getURLs();
    echo $this->render('login', $data);
  }
}