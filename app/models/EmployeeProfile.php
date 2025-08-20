<?php

  require_once '../config/config.php';
  class EmployeeProfile
  { 
    private $name;

    public function getProfileByName($name)
    {
      $conn = new Connection();
      $this->name = $company_name;
      $findProfile = "SELECT * FROM users WHERE name = ?";
      $stmt = $conn->prepare($findProfile);
      $stmt->bind_param("s", $this->name);
      $stmt->execute();

      return $stmt->get_result()->fetch_assoc();
    }

     public function updateProfile($data)
    {
      $conn = new Connection();
      $updateProfile = "UPDATE users SET name = ?, profile_photo = ?, date_of_birth = ?, address = ?, portfolio_url = ?,
                        email = ?, phone = ?, education = ?, skills = ?, resume_url = ?, about_me = ?, social_links = ?,  
                        WHERE name = ?";
      $stmt = $conn->prepare($updateProfile);
      $stmt->bind_param("sssssssssssss",
                         $data['name'], $data['profile_photo'], $data['date_of_birth'], $data['address'], $data['portfolio_url'], $data['email'],
                         $data['phone'], $data['education'], $data['skills'], $data['resume_url'], $data['about_me'],  $data['social_links'],
                         $_SESSION['name']);
      return $stmt->execute();
    }
  }

?>