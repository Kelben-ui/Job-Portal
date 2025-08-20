<?php

  require_once '../models/EmployeeProfile.php';
  class EmployeeProfileController
  {
    private $profile;

    public function ViewProfile()
    { 
        $profile = new EmployeeProfile();
        $EmpProfile = $this->profile->getProfileByName($_SESSION['name']);
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $EmpProfile]);
    }

    public function EditProfile($data)
    {
        $data['name'] = InputHelper::sanitizeString($data['name']);
        $data['profile_photo'] = InputHelper::sanitizeString($data['profile_photo']);
        $data['date_of_birth'] = InputHelper::sanitizeString($data['date_of_birth']);
        $data['address'] = InputHelper::sanitizeString($data['address']);
        $data['portfolio_url'] = InputHelper::sanitizeUrl($data['portfolio_url']);
        $data['email'] = InputHelper::sanitizeEmail($data['email']);
        $data['email'] = InputHelper::validateEmail($data['email']);
        $data['phone'] = InputHelper::validatePhone($data['phone']);
        $data['education'] = InputHelper::sanitizeString($data['education']);
        $data['skills'] = InputHelper::sanitizeString($data['skills']);
        $data['resume_url'] = InputHelper::sanitizeUrl($data['resume_url']);
        $data['about_me'] = InputHelper::sanitizeString($data['about_me']);
        $data['social_links'] = InputHelper::sanitizeString($data['social_links']);
        $profile = new EmployeeProfile();
        
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