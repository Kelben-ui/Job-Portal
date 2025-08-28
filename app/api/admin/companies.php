<?php

  require_once "D:/Xampp/htdocs/JobPortal/app/controllers/AdminController.php";
  header('Content-Type: application/json');

  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $method = $_SERVER['REQUEST_METHOD'];
  $route = $_GET['route'];

  $controller = new AdminController();

  if($uri === '/JobPortal/app/api/admin/companies.php' && $method === 'GET')
  {
    $data = $controller->get_companies();
    echo json_encode(["status" => "success", "message" => $data]);
  }
  

?>