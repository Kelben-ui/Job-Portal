<?php

  require_once "../controllers/AdminController.php";
  header('Content-Type: application/json');

  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
  $method = $_SERVER['REQUEST_METHOD'];
  $route = $_GET['route'];

  $controller = new AdminController();

  if($uri === '/api/admin/users' && $method === 'GET')
  {
    $data = $controller->get_users();
    echo json_encode(["status" => "success", "message" => $data]);
  }
  else if($uri === '/api/admin/companies' && $method === 'GET')
  {
    $data = $controller->get_companies();
    echo json_encode(["status" => "success", "message" => $data]);
  }
  else if($uri === '/api/admin/offers' && $method === 'GET')
  {
    $data = $controller->get_offers();
    echo json_encode(["status" => "success", "message" => $data]);
  }
  else if($uri === '/api/admin/applications' && $method === 'GET')
  {
    $data = $controller->get_applications();
    echo json_encode(["status" => "success", "message" => $data]);
  }
  else if($uri === '/api/admin/offers' && $method === 'DELETE')
  {
    $id = json_decode(file_get_contents('php://input'), true);
    $data = $controller->delete_offer($id);
    echo json_encode(["status" => "success", "message" => $data]);
  }

?>