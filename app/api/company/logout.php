<?php

  require_once 'D:/Xampp/htdocs/JobPortal/app/controllers/AuthCompController.php';

  $company = new AuthCompController();

  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $method = $_SERVER['REQUEST_METHOD'];

  header('Content-Type: application/json');  // All API responses will be JSON


   if($uri === '/JobPortal/app/api/company/logout.php' && $method === 'POST')
  {
    $company->logout();
  }



?>