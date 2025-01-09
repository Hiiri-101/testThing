<?php

require_once __DIR__ . '/../vendor/autoload.php';

use App\Router;
use App\Controller\Customer;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$router = new Router();

$router->get('/customers', [Customer::class, 'getCustomers'] );
$router->get('/customer/{ID}', [Customer::class, 'getCustomer']);

$router->post('/customer', [Customer::class, 'addCustomer'] );
$router->put('/customer/{ID}', [Customer::class, 'updateCustomer']);
$router->delete('/customer/{ID}', [Customer::class, 'deleteCustomer']);


// $router->get('/customers', function() {
//   echo 'customers';
// });

// $router->get('/customer/{ID}', function(array $params = []){
//   echo $params['ID'];
// });


// $router->post('/customer', function() {
//   echo 'add customer';
// });

// $router->put('/customer/{ID}', function(array $params = []) {
//   echo 'update customer ID: ' . $params['ID'];
// });

// $router->delete('/customer/{ID}', function(array $params = []) {
//   echo 'delete customer ID: ' . $params['ID'];
// });



$router->run();