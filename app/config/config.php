<?php
  class Connection  
  {
    private $dbServer = "localhost";
    private $dbUser = "root";
    private $dbName = "job_portal";
    private $dbPassword = "";
    private $conn;
    

    public function __construct ()
    {
      return $this->connect();
    }

    public function connect ()
    {
      try
      {
        $this->conn = new mysqli($this->dbServer,$this->dbUser,$this->dbPassword,$this->dbName);
      }
      catch(mysqli_sql_exception)
      {
        echo "Cannot Connect";
        exit;
      }  

      return $this->conn;
    }

    public function query ($sql) 
    { 
      $conn = $this->connect();
      return $conn->query($sql);
    }

    public function prepare ($sql) 
    {
      return $this->conn->prepare($sql);
    }

    public function getConnection() 
    {
      return $this->conn;
    }

    public function disconnect ()
    {
      return $this->conn->close();
    }
    
    
    
  }
?>