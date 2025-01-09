<?php

namespace App\Controller;

use App\Model\Customer as CustomerModel;

class Customer
{
  private $ee = "e";
  
  private CUstomerModel $customer;

  public function htiedot($method){
    header("Access-Control-Allow-Origin: *");
    header("Access-Control-Allow-Methods:" . $method);
    header("Content-Type: application/json; charset=UTF-8");
  }

  public function getCustomers(){
    //määritetään headers tiedot
    $this->htiedot('GET');

    $customers = $this->customer->getCustomers();

    http_response_code(200);
    echo $customers;
  }

  public function getCustomer(array $params){
    $this->htiedot('GET');

    $customers = $this->customer->getCustomer($params['ID']);

    http_response_code(200);
    echo $customers;
  }

  public function addCustomer(array $params){
    $this->htiedot('POST');

    $customers = $this->customer->addCustomer($params['ID']);

    http_response_code(201);
  }

  public function updateCustomer(array $params){
    $this->htiedot('PUT');

    $customers = $this->customer->updateCustomer($params['ID']);

    http_response_code(200);
  }

  public function deleteCustomer(array $params){
    $this->htiedot('DELETE');

    $customers = $this->customer->deleteCustomer($params['ID']);

    http_response_code(205);
  }
}