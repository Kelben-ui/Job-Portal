<?php

  require_once "D:/Xampp/htdocs/JobPortal/app/controllers/AdminController.php";
  header('Content-Type: application/json');

  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $method = $_SERVER['REQUEST_METHOD'];

  $controller = new AdminController();

  if($uri === '/JobPortal/app/api/admin/offers.php' && $method === 'GET')
  {
    $data = $controller->get_offers();
    echo json_encode(["status" => "success", "message" => $data]);
  }
  else if($uri === '/JobPortal/app/api/admin/offers.php' && $method === 'DELETE')
  {
    $id = json_decode(file_get_contents('php://input'), true);
    $data = $controller->delete_offer($id);
    echo json_encode(["status" => "success", "message" => $data]);
  }

?>