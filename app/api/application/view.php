<?php
  
  header("Content-Type: application/json");
  require_once "../controllers/ApplicationsController.php";

  $controller = new ApplicationsController();
  $method = $_SERVER['REQUEST_METHOD']; // Gets the HTTP request method
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

  try
  {
    if ($uri === "/JobPortal/app/api/applications/view.php" && $method === "GET")
    {
        if(!isset($_GET['email']))
        {
            throw new Exception ("Email is required!");
        }
        $applications = $controller->getByUser($_GET['email']);
        echo json_encode(["success" => true, "count" => count($applications), "data" => $applications]);
    }
    
    else{
        http_response_code(405);
        echo json_encode(["success" => false, "error" => $e->getMessage()]);
    }
  }
  catch(Exception $e)
  {
    http_response_code(500);
    echo json_encode(["success" => false, "error" => $e->getMessage()]);
  }
?>