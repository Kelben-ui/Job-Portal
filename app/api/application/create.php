<?php
  
  header("Content-Type: application/json");
  require_once "../controllers/ApplicationsController.php";

  $controller = new ApplicationsController();
  $method = $_SERVER['REQUEST_METHOD']; // Gets the HTTP request method
  $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

  try
  {
    // CREATE APPLICATION
    if($uri === "/JobPortal/app/api/applications/create.php" && $method === "POST")
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