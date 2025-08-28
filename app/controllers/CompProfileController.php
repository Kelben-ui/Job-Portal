<?php
  require_once 'D:/Xampp/htdocs/JobPortal/app/models/CompanyProfile.php';
  require_once "D:/Xampp/htdocs/JobPortal/app/Services/SessionManager.php";
  class CompProfileController
  {
    private $profile;
    private $session;

    public function ViewProfile()
    { 
        $this->session = new SessionManager();
        $email = $this->session->get("company_email");
        $this->profile = new CompanyProfile();

        if(!$email)
        {
          echo json_encode(['status' => 'error', 'message' => "Not logged in"]);
        }
        else 
        {
          if($CompProfile = $this->profile->getProfileByName($email))
          {
          http_response_code(200);
          echo json_encode(['status' => 'success', 'data' => $CompProfile]);
          }
          else{
          http_response_code(400);
          echo json_encode(['status' => 'failed', 'data' => "error"]);
          }
        }
        
    }

    public function EditProfile($data)
    {
        $profile = new CompanyProfile();
        $data['comp_name'] = InputHelper::sanitizeString($data['comp_name']);
        $data['logo_url'] = InputHelper::sanitizeUrl($data['logo_url']);
        $data['industry'] = InputHelper::sanitizeString($data['industry']);
        $data['location'] = InputHelper::sanitizeString($data['location']);
        $data['website'] = InputHelper::sanitizeUrl($data['website']);
        $data['email'] = InputHelper::sanitizeEmail($data['email']);
        $data['email'] = InputHelper::validateEmailEmail($data['email']);
        $data['contact_info'] = InputHelper::validatePhone($data['contact_info']);
        $data['registration_number'] = InputHelper::sanitizeString($data['registration_number']);
        $data['about'] = InputHelper::sanitizeString($data['about']);
        $data['social_links'] = InputHelper::sanitizeUrl($data['social_links']);
        if($this->profile->updateProfile($data))
        {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Profile updated']);
        }
        else{
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Could not update profile!']);
        }
    }
  }

?>