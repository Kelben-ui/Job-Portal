<?php
  require_once "D:/Xampp/htdocs/JobPortal/app/config/config.php";

  class Admin
  {
    private $conn;

    public function __construct()
    {
      $this->conn = new Connection();
    }
    
    public function getApplications()
    {
        $query = "SELECT applications.app_id, users.name, users.email, offers.Int_title, offers.offer_type, resume, cover_letter, status, 
                  created_at FROM applications INNER JOIN Offers ON applications.Int_id = offers.Int_id,
                  INNER JOIN Users ON applications.user_id = Users.user_id";
        $res = $this->conn->query($query);

        $result = $res->get_result();
        $applications = [];

        while($row = $result->fetch_assoc())
        {
          $applications[] = $row;
        }
        return $applications;
    }

    public function getUsers()
    {
      //$conn = new Connection();
      $query = "SELECT * FROM Users WHERE role = 'Student'";
      $res = $this->conn->query($query);

      $result = $res->get_result();
      $users = [];

        while($row = $result->fetch_assoc())
        {
          $users[] = $row;
        }
        return $users;
    }

    public function getCompanies()
    {
    //  $conn = new Connection();
      $query = "SELECT * FROM Companies";
      $res = $this->conn->query($query);

      $result = $res->get_result();
      $companies = [];

      while($row = $result->fetch_assoc())
      {
        $companies[] = $row;
      }
      return $companies;
    }

    public function getOffers()
    {
      //$conn = new Connection();
      $query = "SELECT * FROM Offers";
      $res = $this->conn->query($query);

      $result = $res->get_result();
      $offers = [];

        while($row = $result->fetch_assoc())
        {
          $offers[] = $row;
        }
        return $offers;
    }

    public function deleteOffer($offer_id)
    {
      //$conn = new Connection();
      $query1 = "DELETE FROM Offers WHERE Int_id = ?";
      $query2 = "DELETE FROM applications WHERE Int_id = ?";

      $res2 = $this->conn->prepare($query2);
      $res2->bind_param("i", $offer_id);
      $res2->execute();

      $res1 = $this->conn->prepare($query1);
      $res1->bind_param("i", $offer_id);
      $res1->execute();

      return true;
    }

  }
?>