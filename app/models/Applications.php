<?php

  require_once "../config/config.php";
  require_once "../helpers/emailHelper.php";

  class Application
  {
    private $resume;
    private $cover_letter;
    private $candidate_email;
    private $offer_name;
    private $offer_type;

    public function create_application($can_email,$offer_name,$offer_type,$resume,$cover_letter)
    {
      $this->candidate_email = $can_email;
      $this->offer_name = $offer_name;
      $this->offer_type = $offer_type;
      $this->resume = $resume;
      $this->cover_letter = $cover_letter;

      $query = "SELECT user_id FROM users WHERE email = ?";
      $connection = new Connection();
      $preparedStmt = $connection->prepare($query);

      $preparedStmt->bind_param("s", $this->candidate_email);
      $preparedStmt->execute();
      $user_id = $preparedStmt->get_result();
      if($user_id->num_rows === 0)
      {
        throw new Exception("User not found");
      }
      $user = $user_id->fetch_assoc();
      $user_id = $user['user_id'];
      $preparedStmt->disconnect();


      $query = "SELECT int_id FROM offers WHERE Int_title = ? AND offer_type = ? ";
      $preparedStmt = $connection->prepare($query);
      $preparedStmt->bind_param("ss", $this->offer_name, $this->offer_type);

      $preparedStmt->execute();
      $int_id = $preparedStmt->get_result();

      if($int_id->num_rows === 0)
      {
        throw new Exception("Offer not found");
      }
      $offer = $int_id->fetch_assoc();
      $int_id = $offer['int_id'];
      $preparedStmt->disconnect();

      //Check if user has an application
      $query = "SELECT app_id FROM applications WHERE user_id = ?, AND int_id = ?";
      $stmt = $connection->prepare($query);
      $stmt->bind_param("ss", $user_id,$int_id);

      $stmt->execute();
      $res = $stmt->get_result();
      if($res->num_rows === 0)
      {
        $query = "INSERT INTO applications (User_id,Int_id,resume,cover_letter,status)
                VALUES(?,?,?,?,'submitted')";
        $preparedStmt = $connection->prepare($query);
        $preparedStmt->bind_param("iiss", $user_id,$int_id,$this->resume,$this->cover_letter);
        $preparedStmt->execute();

        $app_id = $preparedStmt->insert_id;
        $preparedStmt->disconnect();
        //Get Email to notify
        $sql = "SELECT Comp_id FROM Offers WHERE Int_id = ?";
        $stmt = $connection->prepare($sql);
        $stmt->bind_param("i", $int_id);
        $stmt->execute();

        $compId = $stmt->get_result()->fetch_assoc();
        $sql2 = "SELECT Comp_email FROM Companies WHERE Comp_id = ?";
        $stmt = $connection->prepare($sql2);
        $stmt->bind_param("i", $compId);

        $stmt->execute();
        $Comp_email = $stmt->get_result()->fetch_assoc();
        // Send notification via email
        $mailer = new EmailHelper();
        $mailer->sendEmail($Comp_email, "Application Submitted", "Check Account");
        $mailer->sendEmail($can_email, "Application Submitted", "You have Successfully Applied for the $offer_name $offer_type");

        return $app_id;
      }
      else{
        throw new Exception("You have already applied!");
        //return $res;
      }

    }

    public function getApplicationsByUser($email)
    {
      $this->candidate_email = $email;
      $query = "SELECT users.name, offers.offer_type, offers.int_title, applications.resume, 
                applications.cover_letter, applications.created_at FROM applications INNER JOIN offers 
                ON applications.int_id = offers.int_id INNER JOIN users ON applications.user_id = users.user_id
                WHERE users.email = ? ORDER BY applications.created_at DESC";

      $connection = new Connection();
      $stmt = $connection->prepare($query);
      $stmt->bind_param("s", $this->candidate_email);

      $stmt->execute();
      $result = $stmt->get_result();
      return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function updateStatus($applicationId, $newStatus)
    {
      $sql = "UPDATE applications SET status = ? WHERE app_id = ?";
      $stmt = $this->conn->prepare($sql);
      $stmt->bind_param("si", $newStatus, $applicationId);
      $stmt->execute();

      $affected = $stmt->affected_rows;
      $stmt->disconnect();

      if($affected === 0)
      {
        throw new Exception("Application not found or status unchanged");
      }
      return true;
    }


  }

?>