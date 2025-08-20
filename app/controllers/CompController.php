<?php

  class CompController 
  {
    public function __construct ()
    {
        $_SESSION['Company_name'] = filter_input(INPUT_POST, "Company name",FILTER_SANITIZE_SPECIAL_CHARS,);
        $_SESSION['Company_email'] = filter_input(INPUT_POST, "Company email", FILTER_SANITIZE_EMAIL);
        $_SESSION['Registration_Number'] = filter_input(INPUT_POST, "registration number", FILTER_SANITIZE_STRING); //Do not know which option to use
        $_SESSION['Contact_info'] = filter_input(INPUT_POST, "Contact info", FILTER_SANITIZE_STRING);
        
    }
  }

?>
