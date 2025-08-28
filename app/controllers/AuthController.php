<?php
  require 'D:/Xampp/htdocs/JobPortal/app/models/User.php';
  require 'Controller.php';
  require 'D:/Xampp/htdocs/JobPortal/app/helpers/InputHelper.php';
  header('content-Type: application/json');
  class AuthController extends UserController
  {
     public function Signup($data) 
     {
        //Controller::__construct();
       $user = new User();
       $data['name'] = InputHelper::sanitizeString($data['name']);
       //$data['password'] = InputHelper::sanitizeString($data['password']);
       $data['email'] = InputHelper::sanitizeEmail($data['email']);
       $data['email'] = InputHelper::validateEmail($data['email']);
       //$data['phone'] = InputHelper::validatePhone($data['phone']);
       $data['address'] = InputHelper::sanitizeString($data['address']);
       if($user->signup($data) === false)
       {
         http_response_code(401);
         echo json_encode(['status' => 'failed', 'message' => 'Email already exist']);
       }
       else{
         http_response_code(201);
         echo json_encode(['status' => 'success', 'message' => 'Signup Successful']);
       }
       
     }

     public function login($data)  
     {
        //Controller::__construct();
        $user = new User();
        //$data['password'] = InputHelper::sanitizeString($data['password']);
        $data['email'] = InputHelper::sanitizeEmail($data['email']);
        $data['email'] = InputHelper::validateEmail($data['email']);
        if($user->login($data) == "Employee")
        {
          http_response_code(200);
          echo json_encode(['status' => 'success', 'message' => 'Logged in as employee']);
        }
        else if($user->login($data) == "Admin")
        {
          http_response_code(200);
          echo json_encode(['status' => 'success', 'message' => 'Logged in as admin']);
        }
        else{
          http_response_code(401);
          echo json_encode(['status' => 'failed', 'message' => 'Invalid email or password']);
        }
        
     }

     public function logout() 
     {
        $user = new User();
        if($user->logout() == true)
        { 
          http_response_code(200);
          echo json_encode(['status' => 'success', 'message' => 'Logged out Successfully']);
        }
        else
        {
          echo json_encode(['status' => 'failed', 'message' => 'Could not log out']);
        }
     }
  }