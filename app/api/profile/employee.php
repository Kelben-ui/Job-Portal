<?php
   require_once '../controllers/EmployeeProfileController.php';

   $empController = new EmployeeProfileController();

   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $method = $_SERVER['REQUEST_METHOD'];

   header('Content-Type: application/json');

   if($uri === '/api/profile/employee/view' && $method === 'GET')
   {
    $empController->ViewProfile();
   }
   else if($uri === '/api/profile/employee/update' && $method === 'PUT')
   {
    $data = json_decode(file_get_contents('php://input'), true);
    $empController->EditProfile($data);
   }


?>