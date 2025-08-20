<?php
  require_once '../models/CompanyProfile.php';
  class CompProfileController
  {
    private $profile;

    public function ViewProfile()
    { 
        $profile = new CompanyProfile();
        $CompProfile = $this->profile->getProfileByName($_SESSION['Company_name']);
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $CompProfile]);
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