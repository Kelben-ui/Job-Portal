<?php

  require_once "../config/config.php";

  class Application
  {
    private $resume;
    private $cover_letter;
    private $candidate_name;
    private $offer_name;
    private $offer_type;

    public function create_application($can_name,$offer_name,$offer_type,$resume,$cover_letter)
    {
      $this->candidate_name = $can_name;
      $this->offer_name = $offer_name;
      $this->offer_type = $offer_type;
      $this->resume = $resume;
      $this->cover_letter = $cover_letter;

      $query = "SELECT user_id FROM users WHERE name = ?";
      $connection = new Connection();
      $preparedStmt = $connection->prepare($query);

      $preparedStmt->bind_param("s", $this->candidate_name);
      $preparedStmt->execute();
      $user_id = $preparedStmt->get_result();

      $query = "SELECT int_id FROM offers WHERE Int_title = ? AND offer_type = ? ";
      $preparedStmt = $connection->prepare($query);
      $preparedStmt->bind_param("ss", $this->offer_name, $this->offer_type);

      $preparedStmt->execute();
      $int_id = $preparedStmt->get_result();

      $query = "INSERT INTO applications (User_id,Int_id,resume,cover_letter)
                VALUES(?,?,?,?)";
      $preparedStmt = $connection->prepare($query);
      $preparedStmt->bind_param("iiibb", $user_id,$int_id,$this->resume,$this->cover_letter);
      $preparedStmt->execute();

    }

    public function delete_application()
    {}
  }

?>