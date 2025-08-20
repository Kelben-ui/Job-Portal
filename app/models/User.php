<?php
  require "../config/config.php";

  class User {
    protected $name;
    protected $email;
    protected $password;
    protected $role;
    protected $phone;
    protected $address;
    protected $created_at;

    public function __construct ()
    {
      
    }

    public function signup ($data)
    {
        $this->name = $data['name'];
        $this->email = $data['email'];
        $this->password = password_hash($data['password'],PASSWORD_DEFAULT);
        $this->phone = $data['phone'];
        $this->address = $data['address'];
        $this->role = "employee";

        $connection = new Connection ();

        $sql = "SELECT user_id FROM users WHERE email = ?";
        $preparedSql =$connection->prepare($sql);
        $preparedSql->bind_param("s", $email);
        $preparedSql->execute();
        $result = $preparedSql->get_result();
        // $email_address = $this->email;
        //$count = $connection->query($sql);
        //$count = $preparedSql->fetchAll();

        if($result->num_rows>0)
        {
          return false;
        }
        else
        {
          $insert = "INSERT INTO users (name,email,password,phone,address,role)
                   VALUES(?,?,?,?,?,?)";
        
          $preparedResult = $connection->prepare($insert);
          $preparedResult->bind_param("ssssss", $name,$email,$password,$phone,$address,$role);

          $name = $this->name;
          $email = $this->email;
          $password = $this->password;
          $phone = $this->phone;
          $address = $this->address;  
          $role = $this->role;

          $preparedResult->execute();

          return true;
          //echo "Signup Successful!";
        }
       
    }

    public function login ($data)
    {
        $connection = new Connection ();
        $this->email = $data['email'];
        $this->password = $data['password'];
        $this->role = $data['role'];
        $sql = "SELECT password FROM users WHERE email = ?";
        $preparedSql = $connection->query($sql);
        $preparedSql->bind_param("s", $email);

        $email = $this->email;

        $preparedSql->execute();
        $result = $preparedSql->get_result();

        //$result = $connection->query($sql);

        if(password_verify($this->password,$result))
        {
          if($this->role == 'employee')
          {
            return "employee";
          }
          if($this->role == 'Admin')
          {
            return "admin";
          }
        }
        else 
        {
          return "error";
        }
    }

    public function logout ()
    {
      $connection = new Connection ();
      $connection->disconnect();

      return true;
      
    }
  } 