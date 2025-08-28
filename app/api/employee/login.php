<?php

  require_once 'D:/Xampp/htdocs/JobPortal/app/controllers/AuthController.php';

  $employee = new AuthController();

  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $method = $_SERVER['REQUEST_METHOD'];

  header('Content-Type: application/json');  // All API responses will be JSON

   if($uri === '/JobPortal/app/api/employee/login.php' && $method === 'POST')
  {
    $data = json_decode(file_get_contents('php://input'), true);
     if(empty($data['email']) || empty($data['password']) || empty($data['role'])) 
   {
     echo json_encode(['error' => 'All fields are required']);
   }
    else
    {
        $employee->login($data);
    }
  }


?>