<?php
  
  header("Content-Type: application/json");
  require_once "../controllers/ApplicationsController.php";

  $controller = new ApplicationsController();
  $method = $_SERVER['REQUEST_METHOD']; // Gets the HTTP request method
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

  try
  {
    
    if ($uri === "/JobPortal/app/api/applications/update.php" && $method === "PUT")
    {
      $data = json_decode(file_get_contents("php://input"), true);
      if(!empty($data['application_id']) || !empty($data['status']))
        {
            throw new Exception("All fields are required");
        }
      $controller->updateStatus($data);
      echo json_encode(["success" => true, "message" => "Application Status updated successfully"]);
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