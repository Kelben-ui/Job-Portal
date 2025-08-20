<?php

  require_once "CompController.php";
  require_once "../models/Companies.php";

  class AuthCompController extends CompController
  {
    public function Signup($data)
    {
        $Company = new Company();
        $data['company_name'] = InputHelper::sanitizeString($data['company_name']);
        //$data['company_password'] = InputHelper::sanitizeString($data['company_password']);
        $data['registration_number'] = InputHelper::sanitizeString($data['registration_number']);
        $data['company_email'] = InputHelper::sanitizeEmail($data['company_email']);
        $data['company_email'] = InputHelper::validateEmail($data['company_email']);
        if($Company->signup($data) == false)
        { 
          http_response_code(400);
          echo json_encode(['status' => 'failed', 'message' => 'Account already exist']);
        }
    }

    public function login($data)
    {
        $Company = new Company();
        $data['company_email'] = InputHelper::sanitizeEmail($data['company_email']);
        $data['company_email'] = InputHelper::validateEmail($data['company_email']);
        //$data['company_password'] = InputHelper::sanitizeString($data['company_password']);
        if($Company->login($data) == true)
        {
          http_response_code(200);
          echo json_encode(['status' => 'Success', 'message' => 'Login Successful']);
        }
        else{
          http_response_code(400);
          echo json_encode(['status' => 'failed', 'message' => 'Invalid email of password']);
        }
    }

    public function logout()
    {
        $Company = new Company();
        $Company->logout();
        http_response_code(200);
        echo json_encode(['status' => 'Success', 'message' => 'Logout Successful']);
    }
  }

?>