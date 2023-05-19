<?php

namespace App\Controller;
use Core\Controller;
use Core\Database;

class HomeController extends Controller
{
  public function __construct(Database $db) {
    parent::__construct($db);
  }

  public function index() {
    $data['title'] = 'Accueil ' . $GLOBALS['siteName'];
    echo $this->render('home', $data);
  }
}