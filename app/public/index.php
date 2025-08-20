<?php
   require '../Services/SessionManager.php';
   

   $session = new SessionManager();
   include ("../Routes/offerAPI.php");
   include ("../Routes/authAPI.php");
   include ("../Routes/profileAPI.php");

?>   