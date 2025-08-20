<?php
  
  class UserController 
  { 
    public function __construct ()
    {
        $_SESSION['name'] = filter_input(INPUT_POST, "name",FILTER_SANITIZE_SPECIAL_CHARS,);
        $_SESSION['email'] = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);
        $_SESSION['password'] = filter_input(INPUT_POST, "password", FILTER_SANITIZE_STRING); //Do not know which option to use
        $_SESSION['address'] = filter_input(INPUT_POST, "address", FILTER_SANITIZE_STRING);
        $_SESSION['phone'] = filter_input(INPUT_POST, "phone", FILTER_SANITIZE_NUMBER_INT);
        //$_SESSION['role'] = $_POST["role"];

        
        
    }
  }