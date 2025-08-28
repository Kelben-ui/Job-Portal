<?php

  require_once 'D:/Xampp/htdocs/JobPortal/app/controllers/AuthController.php';

  $employee = new AuthController();

  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $method = $_SERVER['REQUEST_METHOD'];
  //$data = json_decode(file_get_contents('php://input'), true);
  
  //var_dump(file_get_contents("php://input"));
  header('Content-Type: application/json');  // All API responses will be JSON
  if($uri === '/JobPortal/app/api/employee/signup.php' && $method === 'POST')
    {
    $data = json_decode(file_get_contents('php://input'), true);
    //var_dump(array_keys($data));
    //$data = $_POST;
    //$data['email'] = $_POST['email'];
    //--var_dump($data);
    if(empty($data['email']) || empty($data['password']) || empty($data['name']) || empty($data['phone']) || empty($data['address']) || empty($data['role']))
    {
      //echo json_encode(['email' => $data['email']]);
      echo json_encode(['error' => 'All fields are required']);
      
    }
    else
    {
      $employee->Signup($data);
    }
  }
  else {
    echo json_encode(['error' => 'The path is wrong ',$uri]);
  }




?>