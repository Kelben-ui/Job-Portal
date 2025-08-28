<?php

  require_once "CompController.php";
  require_once "D:/Xampp/htdocs/JobPortal/app/models/Companies.php";
  require_once "D:/Xampp/htdocs/JobPortal/app/helpers/InputHelper.php";
  require_once "D:/Xampp/htdocs/JobPortal/app/Services/SessionManager.php";

  class AuthCompController extends CompController
  { 
    public function Signup($data)
    {
        $Company = new Company();
        $data['company_name'] = $_SESSION['company_name'] = InputHelper::sanitizeString($data['company_name']);
        //$data['company_password'] = InputHelper::sanitizeString($data['company_password']);
        $data['registration_number'] = $_SESSION['registration_number'] = InputHelper::sanitizeString($data['registration_number']);
        $data['company_email'] =  InputHelper::sanitizeEmail($data['company_email']);
        $data['company_email'] = $_SESSION['company_email'] = InputHelper::validateEmail($data['company_email']);
        $data['company_password'] = $_SESSION['company_password'] = InputHelper::sanitizeString($data['company_password']);
        if($Company->signup($data) == false)
        { 
          http_response_code(400);
          echo json_encode(['status' => 'failed', 'message' => 'Account already exist']);
        }
        else
        {
          http_response_code(200);
          echo json_encode(['status' => 'success', 'message' => 'Signup Successful!']);
        }
    } 

    public function login($data)
    {
        $session = new SessionManager();
        $Company = new Company();
        $data['company_email'] = InputHelper::sanitizeEmail($data['company_email']);
        $data['company_email'] = $_SESSION['company_email'] = InputHelper::validateEmail($data['company_email']);
        $data['company_password'] = $_SESSION['company_password'] = InputHelper::sanitizeString($data['company_password']);
        //$data['company_password'] = InputHelper::sanitizeString($data['company_password']);
        if($Company->login($data) == true)
        {
          $session->set("company_email", $data['company_email']);
          http_response_code(200);
          echo json_encode(['status' => 'Success', 'message' => 'Login Successful']);
        }
        else{
          http_response_code(400);
          echo json_encode(['status' => 'failed', 'message' => 'Invalid email or password']);
        }
    }

    public function logout()
    {
        $Company = new Company();
        if($Company->logout())
        {
          http_response_code(200);
          echo json_encode(['status' => 'Success', 'message' => 'Logout Successful']);
        }
        else{
          http_response_code(400);
          echo json_encode(['status' => 'failed', 'message' => 'Logout Unsuccessful']);
        }
    }
  }

?>