<?php
   require_once '../controllers/CompProfileController.php';
   require_once '../controllers/EmployeeProfileController.php';

   $compController = new CompProfileController();
   $empController = new EmployeeProfileController();

   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $method = $_SERVER['REQUEST_METHOD'];

   header('Content-Type: application/json');

   if($uri === '/api/company/view' && $method === 'GET')
   {
    $compController->ViewProfile();
   }
   else if($uri === '/api/company/update' && $method === 'PUT')
   {
    $data = json_decode(file_get_contents('php://input'), true);
    $compController->EditProfile($data);
   }
   else if($uri === '/api/employee/view' && $method === 'GET')
   {
    $empController->ViewProfile();
   }
   else if($uri === '/api/employee/update' && $method === 'PUT')
   {
    $data = json_decode(file_get_contents('php://input'), true);
    $empController->EditProfile($data);
   }


?>