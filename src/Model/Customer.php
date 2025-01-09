<?php

namespace App\Model;

use App\Database;
use PDO;

class Customer {

  private PDO $db;
 
  public function __construct()
  {
    $this->db = (new Database())->getConnection();
  }

  public function addCustomer(mixed $data){

    $sql = "INSERT INTO asiakas
            (etunimi, sukunimi, sahkoposti, lahiosoite, postinumero,
            postitoimipaikka, puhelin, henkilotunnus)
            VALUES
            (?, ?, ?, ?, ?
            ?, ?, ?)";

    $stmt = $this->db->prepare($sql);

    return $stmt->execute(array($data->etunimi, $data->etunimi, $data->sukunimi,
    $data->sahkoposti, $data->lahiosoite, $data->postinumero, $data->postitoimipaikka,
    $data->puhelin, $data->henkilotunnus));
  }

  public function getCustomers(){

    $sql = "SELECT * 
            FROM asiakas";

    $stmt = $this->db->prepare($sql);
    $stmt->execute();

    $customers =  $stmt->fetchAll(PDO::FETCH_ASSOC);

    return json_encode($customers);
  }

  public function getCustomer($id){

    $sql = "SELECT *
            FROM asiakas
            WHERE asiakasID = :asiakasID";
    
    $stmt = $this->db->prepare($sql);
    $stmt->bindParam(':asiakasID', $id);
    $stmt->execute();

    if($stmt->rowCount() === 1){
      $customer = $stmt->fetch(PDO::FETCH_ASSOC);

      return json_encode($customer);
    } else {

      return json_encode(array("viesti" => "Asiakastietoja ei voida palauttaa"));
    }

  }

  public function updateCustomer(array $data){

    $sql = "UPDATE asiakas
            SET (etunimi = , sukunimi, sahkoposti, lahiosoite, postinumero,
            postitoimipaikka, puhelin, henkilotunnus)
            WHERE data = $data ";
    
    $stmt = $this->db->prepare($sql);
    $stmt->execute();
  }


  public function deleteCustomer($id){

    $sql = "DELETE
            FROM asiakas
            WHERE id = $id ";
    
    $stmt = $this->db->prepare($sql);

  }
}