<?php

namespace App\Model;

class ArticleModel
{
  private $pdo;

  public function __construct()
  {
      try {
          $this->pdo = new \PDO('mysql:dbname=pas;dbhost=localhost', 'isyll', 'xCplm_');
          $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
      }
      catch (\PDOException $e) {
          echo $e->getMessage();
      }
  }

  public function all() : array
  {
    return $this->pdo->query('SELECT * FROM article')->fetchAll();
  }

  public function insert(array $datas)
  {
    $this->pdo
      ->prepare('INSERT INTO article(libelle, prix) VALUES(:libelle, :prix)')
      ->execute($datas);
  }
}