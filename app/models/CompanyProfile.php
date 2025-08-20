<?php

  require_once '../config/config.php';
  class CompanyProfile 
  {
    private $name;
    private $email;
    private $phone;
    private $social_links;
    private $logo_url;
    private $industry;
    private $location;
    private $website;
    private $about;
    private $conn;
    private $password;

    public function getProfileByName($company_name)
    {
      $conn = new Connection();
      $this->name = $company_name;
      $findProfile = "SELECT * FROM Companies WHERE Comp_name = ?";
      $stmt = $conn->prepare($findProfile);
      $stmt->bind_param("s", $this->name);
      $stmt->execute();

      return $stmt->get_result()->fetch_assoc();
    }

    public function updateProfile($data)
    {
      $conn = new Connection();
      $updateProfile = "UPDATE Companies SET Comp_name = ?, Comp_logo_url = ?, Comp_industry = ?, Comp_location = ?, Comp_website = ?,
                        Comp_email = ?, Comp_contact_info = ?, Comp_registration_number = ?, about = ?, social_links = ?,  
                        WHERE Comp_name = ?";
      $stmt = $conn->prepare($updateProfile);
      $stmt->bind_param("sssssssssss",
                         $data['Comp_name'], $data['logo_url'], $data['industry'], $data['location'], $data['website'], $data['email'],
                         $data['contact_info'], $data['registration_number'], $data['about'], $data['social_links'], $_SESSION['Company_name']);
      return $stmt->execute();
    }

    public function resetPassword()
    {}

    public function verify_password($password)
    {
      $this->password = $password;
      $conn = new Connection();
      $getPassword = "SELECT Comp_password FROM Companies WHERE comp_email = ?";
      $stmt = $conn->prepare($getPassword);
      $stmt->bind_param("s", $_SESSION['Company_email']);
      $result = $stmt->execute();

      if(password_verify($this->password,$result))
      {
        $code = random_int(10000000,99999999);
        return $code;
      }
    }
     
  }

?>