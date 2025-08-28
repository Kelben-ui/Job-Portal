<?php
  
  require_once "D:/Xampp/htdocs/JobPortal/app/models/Admin.php";

  class AdminController
  {
    private $Admin;

    public function __construct()
    {
        $this->Admin = new Admin();
    }

    public function get_users()
    {
        $data = $this->Admin->getUsers();
        return $data;
    }

    public function get_applications()
    {
        $data = $this->Admin->getApplications();
        return $data;
    }

    public function get_offers()
    {
        $data = $this->Admin->getOffers();
        return $data;
    }

    public function get_companies()
    {
        $data = $this->Admin->getCompanies();
        return $data;
    }

    public function delete_offer($offer_id)
    {
        $data = $this->Admin->deleteOffer($offer_id);
        return $data;
    }
  }

?>