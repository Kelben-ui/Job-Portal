<?php

  require_once '../controllers/AuthController.php';

  $employee = new AuthController();

  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $method = $_SERVER['REQUEST_METHOD'];

  header('Content-Type: application/json');  // All API responses will be JSON

  if($uri === '/api/employee/signup' && $method === 'POST')
  {
    $data = json_decode(file_get_contents('php://input'), true);
    if(empty($data['email']) || empty($data['password']) || empty($data['name']) || empty($data['phone']) || empty($data['address']) || empty($data['role']))
    {
      echo json_encode(['error' => 'All fields are required']);
    }
    else
    {
      $employee->Signup($data);
    }
  }

  else if($uri === '/api/employee/login' && $method === 'POST')
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

  else if($uri === '/api/employee/logout' && $method === 'POST')
  {
    $employee->logout();
  }



?>