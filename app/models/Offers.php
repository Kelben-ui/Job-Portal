<?php

  require_once "D:/Xampp/htdocs/JobPortal/app/config/config.php";

  class Offer
  {
    private $Comp_email;
    private $Offer_title;
    private $Description;
    private $Requirements;
    private $location;
    private $Salary;
    private $Deadline;
    private $Status;
    private $Offer_type;

    public function Create_offer($data)
    {
        $this->Comp_email = $_SESSION['Comp_email'];
        $this->Offer_title = $data['Offer_title'];
        $this->Description = $data['Description'];
        $this->Requirements = $data['Requirements'];
        $this->location = $data['location'];
        $this->Salary = $data['Salary'];
        $this->Deadline = $data['Deadline'];
        $this->Status = $data['Status'];
        $this->Offer_type = $data['Offer_type'];
        
        $Connection = new Connection();
        $search = "SELECT Comp_id FROM Companies WHERE Comp_email = ?";
        $preparedSearch = $Connection->prepare($search);
        $preparedSearch->bind_param("s", $Comp_email);

        $Comp_email = $this->Comp_email;
        $preparedSearch->execute();
        $result = $preparedSearch->get_result();

        if($result->num_rows > 0)
        {
            $check_id = "SELECT Deadline,Offer_type,Int_title FROM Offers WHERE Comp_id = ?";
            $preparedQuery = $Connection->prepare($check_id);
            $preparedQuery->bind_param("s", $id);

            $id = $result;
            $preparedQuery->execute();
            $queryResult = $preparedQuery->result();

            if($queryResult->num_rows > 0)
            {
                while($row = $queryResult->fetch_object())
                {
                    if((strcmp($row->Deadline,$this->Deadline)) && (strcmp($row->Offer_type,$this->Offer_type)) && (strcmp($row->$Offer_title,$this->Int_title)))
                    {
                        echo json_encode(['error' => 'Internship already exist']);
                        exit;
                    }
                }
            }
            else 
            {
                $offer = "INSERT INTO Offers (Comp_id,Int_title,Int_description,Int_requirements,Int_location,Salary,Deadline,Status,Offer_type)
                   VALUES(?,?,?,?,?,?,?,?,?)";
                $preparedOffer = $Connection->prepare($offer);
                $preparedOffer->bind_param("issssisss", $Company_id,$Offer_title,$Description,$Requirements,$location,$Salary,$Deadline,$Status,$Offer_type);

                $Company_id = $result;
                $Offer_title = $this->Offer_title;
                $Description = $this->Description;
                $Requirements = $this->Requirements;
                $location = $this->location;
                $Salary = $this->Salary;
                $Deadline = $this->Deadline;
                $Status = $this->Status;
                $Offer_type = $this->Offer_type;
                return $preparedOffer->execute();
            }

        }

    }

    public function Read_offer($Offer_type)
    {
        $Connection = new Connection();
        $read = "SELECT * FROM Offers WHERE Offer_type = ?";
        $preparedRead = $Connection->prepare($read);
        $preparedRead->bind_param("s", $Off_type);

        $Off_type = $Offer_type;
        $preparedRead->execute();

        $Offers = [];
        $result = $preparedRead->get_result();
        while($row = $result->fetch_assoc())
        {
            $Offers[] = $row;
        }
        return $Offers;
    }

    public function Read_All_Offers()
    {
        $Connection = new Connection();
        $read = "SELECT * FROM Offers";
        $result = $Connection->query($read);

        $Offers = [];
        while($row = $result->fetch_assoc())
        {
            $Offers[] = $row;
        }
        return $Offers;
    }

    public function getById($email,$id)
    {
        $Connection = new Connection();
        $this->Comp_email = $Comp_email;
        $search = "SELECT Comp_id FROM Companies WHERE Comp_email = ?";
        $preparedSearch = $Connection->prepare($search);
        $preparedSearch->bind_param("s", $Company_email);

        $Company_email = $this->Comp_email;
        $preparedSearch->execute();
        $result = $preparedSearch->get_result();

        $sql = "SELECT * FROM Offers WHERE Comp_id = ? && Int_id = ?";
        $preparedSql = $Connection->prepare($sql);
        $preparedSql->bind_param("ii", $result,$id);
        $preparedSql->execute();

        return $preparedSql->get_result()->fetch_assoc();

        
    }

    public function Update_Offer($Comp_email,$Offer_id,$data)
    {
        $Connection = new Connection();
        $this->Comp_email = $Comp_email;
        $search = "SELECT Comp_id FROM Companies WHERE Comp_email = ?";
        $preparedSearch = $Connection->prepare($search);
        $preparedSearch->bind_param("s", $Company_email);

        $Company_email = $this->Comp_email;
        $preparedSearch->execute();
        $result = $preparedSearch->get_result();

        $sql = "UPDATE Offers 
                 SET Int_title = ?, Int_description = ?, Int_requirements = ?, Int_location = ?, Salary = ?, Deadline = ?, Status = ?
                 WHERE Comp_id = ? && Int_id = ?";
        $stmt = $Connection->prepare($sql);
        $stmt->bind_param("ssssissii", 
                           $data['title'],$data['description'],$data['requirements'],$data['location'],
                           $data['salary'],$data['deadline'],$data['Status'],$result,$Offer_id);
         return $stmt->execute();

    }

    public function Delete_offer($Comp_email,$Offer_id)
    {
        $Connection = new Connection();
        $search = "SELECT Comp_id FROM Companies WHERE Comp_email = ?";
        $preparedSearch = $Connection->prepare($search);
        $preparedSearch->bind_param("s", $Comp_email);

        $Comp_email = $this->Comp_email;
        $preparedSearch->execute();
        $result = $preparedSearch->get_result();

        $sql = "DELETE FROM Offers
                WHERE Comp_id = ? && Int_id = ?";
        $stmt = $Connection->prepare($sql);
        $stmt->bind_param("ii", $result,$Offer_id);

        return $stmt->execute();
    }

    public function Search_offers(string $q = '', string $kind = 'all' ) : array
    {
        $sql = "SELECT offers.Int_title, offers.Int_description, offers.Int_requirements, offers.Int_location, offers.salary, offers.deadline,
                offers.status, offers.offer_type, companies.comp_name 
                FROM offers INNER JOIN companies ON offers.comp_id = companies.comp_id WHERE 1=1";
        $params = [];
        $types = "";

        $kind = strtolower(trim($kind));
        if(!in_array($kind, ['all', 'job', 'internship'], true))
        {
            $kind = 'all';
        }

        if($kind !== 'all')
        {
            $sql  .= " AND type = ?";
            $params[] = $kind;
            $types .= "s";
        }

        $q = trim($q);
        if($q !== '')
        {
            $columns = ['Int_title', 'Int_description', 'Int_requirements', 'Int_location', 'salary', 'deadline', 'status', 'offer_type', 'Comp_name'];
            $words = preg_split('/\s+/', $q);

            foreach($words as $word)
            {
                $sql .= " AND (";
                $orParts = [];
                foreach($columns as $column)
                {
                    $orParts[] = "$column LIKE ?";
                }
                $sql .= implode(' OR ', $orParts) . ")";

                $like = "%{$word}%";
                foreach ($columns as $_) 
                {
                    $params[] = $like;
                    $types  .= "s";
                }
            }
        }

        $sql .= " ORDER BY created_at ASC";
        
        $connection = new Connection();
        $stmt = $connection->prepare($sql);

        if(!$stmt)
        {
            throw new Exception ("Prepare failed: " . $connection->error);
        }

        if(!empty($params))
        {
            $bindArgs = [];
            $bindArgs = $types;

            foreach($params as $i => $val)
            {
                $bindArgs[] = &$params[$i];
            }
            call_user_func_array([$stmt, 'bind_param'], $bindArgs);
        }

        $stmt->execute();
        $result = $stmt->get_result();
        $rows = $result->fetch_all(MYSQLI_ASSOC);

        $stmt->disconnect();
        return $rows;
    }
  }

?>
