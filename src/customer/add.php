<?php

//määritetään headers tiedot
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] != 'POST'){
  http_response_code(405);
  echo json_encode(array("viesti" => "Metodi ei ole sallittu"));
  exit;
}


// 
