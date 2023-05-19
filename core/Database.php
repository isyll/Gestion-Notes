<?php

namespace Core;

use PDO;

class Database
{
  private PDO $pdo;

  public function __construct(
    string $dbname,
    string $host = 'localhost',
    string $user = 'root',
    string $password = ''
  ) {
    try {
      $this->pdo = new PDO("mysql:dbname=$dbname;dbhost=$host", $user, $password);
      $this->pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    }
    catch (\PDOException $e) {
      echo $e->getMessage();
    }
  }

  public function getPDO()
  {
    return $this->pdo;
  }
}