<?php
  require_once "../config/config.php";
  class Company
  {
    private $company_name;
    private $description;
    private $location;
    private $contact_info;
    private $logo_url;
    private $website;
    private $Comp_registration_number;
    private $Comp_email;
    private $Comp_password;
    private $created_at;

    public function signup($data)
    {
        $this->company_name = $data['company_name'];
        $this->Comp_password = $data['company_password'];
        $this->Comp_registration_number = $data['registration_number'];
        $this->Comp_email = $data['company_email'];

        $sql = "SELECT Comp_id FROM Companies WHERE Comp_email = ?";
        $connection = new Connection();
        $preparedResult = $connection->prepare($sql);
        $preparedResult->bind_param("s", $company_email);
        $company_email = $this->Comp_email;

        $preparedResult->execute();
        $result = $preparedResult->get_result();

        if($result->num_rows > 0)
        {
            return false;
        }
        else
        {
            $insert = "INSERT INTO Companies(Comp_name,Comp_password,Comp_registration_number,Comp_email)
                        VALUES(?,?,?,?)";
            $preparedSql = $connection->prepare($insert);
            $preparedSql->bind_param("ssss", $Comp_name,$Comp_pass,$Comp_registration_number,$Comp_email);

            $Comp_name = $this->company_name;
            $Comp_pass = $this->Comp_password;
            $Comp_registration_number = $this->Comp_registration_number;
            $Comp_email = $this->Comp_email;

            $preparedSql->execute();
        }

    }

    public function login ($data)
    {
        $this->comp_email = $data['company_email'];
        $this->Comp_password = $data['company_password'];

        $sql = "SELECT Comp_password FROM Companies WHERE Comp_email = ?";
        $connection = new Connection();
        $preparedStmt = $connection->prepare($sql);
        $preparedStmt->bind_param("s", $Comp_email);

        $Comp_email = $this->Comp_email;
        $preparedStmt->execute();

        $result = $preparedStmt->get_result();
        if(strcmp($result,$Comp_password)) 
        {
          return true;
        }
        else 
        {
          return false;
        }
    }

    public function logout ()
    {
      $connection = new Connection ();
      $connection->disconnect();

      
    }

  }
?>