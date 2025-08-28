<?php
   require_once 'D:\Xampp\htdocs\JobPortal\app\controllers\CompProfileController.php';

   $compController = new CompProfileController();

   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $method = $_SERVER['REQUEST_METHOD'];
   
   //echo json_encode(['uri' => $uri, 'method' => $method]);
   header('Content-Type: application/json');

   if($uri === '/JobPortal/app/api/profile/company/view.php' && $method === 'GET')
   {
    $compController->ViewProfile();
   }
   else{
      http_response_code(300);
        echo json_encode(['status' => 'failed', 'data' => "error"]);
   }


?>