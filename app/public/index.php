<?php
   require '../Services/SessionManager.php';
   

   $session = new SessionManager();
   include_once ("../api/admin/users.php");
   include_once ("../api/admin/applications.php");
   include_once ("../api/admin/companies.php");
   include_once ("../api/admin/offers.php");
   include_once ("../api/company.php");
   include_once ("../api/employee.php");
   include_once ("../api/applications.php");
   include_once ("../api/offers.php");
   include_once ("../api/profile/company.php");
   include_once ("../api/profile/employee.php");

?>   