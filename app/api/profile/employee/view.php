<?php
   require_once '../controllers/EmployeeProfileController.php';

   $empController = new EmployeeProfileController();

   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $method = $_SERVER['REQUEST_METHOD'];

   header('Content-Type: application/json');

   if($uri === '/api/profile/employee/view.php' && $method === 'GET')
   {
    $empController->ViewProfile();
   }
   


?>