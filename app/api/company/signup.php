<?php

  require_once 'D:/Xampp/htdocs/JobPortal/app/controllers/AuthCompController.php';

  $company = new AuthCompController();
 
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $method = $_SERVER['REQUEST_METHOD'];

  header('Content-Type: application/json');  // All API responses will be JSON


  if($uri === '/JobPortal/app/api/company/signup.php' && $method === 'POST')
  {
    $data = json_decode(file_get_contents('php://input'), true);
    if(empty($data['company_name']) || empty($data['company_email']) || empty($data['registration_number']) || empty($data['company_password']))
   {
      echo json_encode(['error' => 'All fields are required']);
   }
    else
    {
        $company->Signup($data);
    }
  }

  



?>