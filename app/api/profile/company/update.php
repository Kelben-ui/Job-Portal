<?php
   require_once 'D:\Xampp\htdocs\JobPortal\app\controllers\CompProfileController.php';

   $compController = new CompProfileController();

   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $method = $_SERVER['REQUEST_METHOD'];

   header('Content-Type: application/json');

    if($uri === '/api/profile/company/update.php' && $method === 'PUT')
   {
    $data = json_decode(file_get_contents('php://input'), true);
    $compController->EditProfile($data);
   }


?>