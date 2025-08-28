<?php
  
  header("Content-Type: application/json");
  require_once "../controllers/ApplicationsController.php";

  $controller = new ApplicationsController();
  $method = $_SERVER['REQUEST_METHOD']; // Gets the HTTP request method

  try
  {
    // CREATE APPLICATION
    if($method === "POST")
    {
        $data = json_decode(file_get_contents("php://input"), true);
        if(!$data)
        {
            throw new Exception("Invalid JSON input");
        }
        if(!isset($_FILES['resume']))
        {
          throw new Exception ("Resume and Cover letter are required");
        }
        $resumeFile = $_FILES['resume'];
        $uploadResumeDir = "../uploads/resumes/"; // Defines the folder where CVs will be stored
        
        if(!is_dir($uploadResumeDir))
        {
          mkdir($uploadResumeDir, 0777, true);  // Create the folder with full permissions if it doesn't exist
        }
        $fileType = strtolower(pathinfo($resumeFile["name"], PATHINFO_EXTENSION));
        if($fileType !== "pdf")
        {
          throw new Exception ("Only PDF files are allowed for resumes.");
        }
        //Generate unique file name
        $resumePath = $uploadDir . uniqid("cv_") . ".pdf"; // Creates a unique file name for the CV so files don't overwrite each other.

        //Move uploaded file
        if(!move_uploaded_file($resumeFile["tmp_name"], $resumePath))
        {
          throw new Exception ("Failed to upload resume.");
        }
        $data['resume'] = $resumePath;

        //Save to DB using controller
        $app_id = $controller->create($data);
        echo json_encode(["success" => true, "message" => "Application submitted successfully",
                           "application_id" => $app_id, "resumePath" => $resumePath]);
    }
    else if ($method === "GET")
    {
        if(!isset($_GET['email']))
        {
            throw new Exception ("Email is required!");
        }
        $applications = $controller->getByUser($_GET['email']);
        echo json_encode(["success" => true, "count" => count($applications), "data" => $applications]);
    }
    else if ($method === "PUT")
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