<?php

namespace App\Controller;
use Core\Controller;
use Core\Database;
use Core\Router;

class HomeController extends Controller
{
  private Router $router;

  public function __construct(Database $db, Router $router) {
    parent::__construct($db);
    $this->router = $router;
  }

  public function index() {
    $data['title'] = 'Accueil ' . $GLOBALS['siteName'];
    $data['urls'] = $this->router->getURLs();
    echo $this->render('home', $data);
  }
}