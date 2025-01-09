<?php

namespace App;

use PDO, PDOException;

class Database
{
  private PDO $pdo;

  public function __construct()
  {
    try {

      $dsn = "mysql:host=" . $_ENV['DB_HOST'] . ";dbname=" . $_ENV['DB_NAME'];

      $this->pdo = new PDO($dsn, $_ENV['DB_USER'],'' ,[
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
      ]);

    } catch (PDOException $e) {
      die("Tietokantaan ei saada yhteyttä");
    }
  }

  public function getConnection(){
    return $this->pdo;
  }
}
