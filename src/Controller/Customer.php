<?php

namespace App\Controller;

use App\Model\Customer as CustomerModel;

class Customer
{
  private CustomerModel $customer;

  public function htiedot($method){
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods:" . $method);
    header("Content-Type: application/json; charset=UTF-8");
  }

  public function success($code){
    http_response_code($code);
    echo json_encode([
      "viesti" => "Asiakastietojen muokkaus onnistui"
    ]);
  }
  public function failure($code){
    http_response_code($code);
    echo json_encode([
      "viesti" => "Asiakastietojen muokkaus epäonnistui"
    ]);
  }


  public function __construct()
  {
    $this->customer = new CustomerModel();
  }

  public function getCustomers(){
    //määritetään headers tiedot
    $this->htiedot('GET');
    
    $customers = $this->customer->getCustomers();

    http_response_code(200);
    echo $customers;

  }

  public function getCustomer(array $params){
    echo 'Customer ID:' . $params['ID'];
  }

  public function addCustomer(mixed $data){
    $this->htiedot('POST');

    if( $this->customer->addCustomer( $data ) ){
      $this->success(201);
    } else {
      $this->failure(500);
    }
  }

  public function updateCustomer(array $params){
    $this->htiedot('PUT');

    if( $this->customer->updateCustomer($params) ){
      $this->success(200);
    } else {
      $this->failure(400);
    }
  }

  public function deleteCustomer(array $params){
    $this->htiedot('DELETE');

    if( $this->customer->deleteCustomer($params) ){
      $this->success(204);
    } else {
      $this->failure(400);
    }
  }
}