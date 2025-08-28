<?php
  require_once '../models/Applications.php';

  class ApplicationsController
  {
    private $application;

    public function __construct()
    {
        $this->application = new Application();
    }

    public function create($data)
    {
        if(!isset($data['email'],$data['offer_title'], $data['offer-type'], $data['resume'], $data['cover_letter']))
        {
            throw new Exception("All fields are required!");
        }

        return $this->application->create_application($data['email'],$data['offer_name'],$data['offer_type'],
                                                      $data['resume'],$data['cover_letter']);
    }

    public function getByUser($email)
    {
        return $this->application->getApplicationsByUser($email);
    }

    public function updateStatus($data)
    {
      if(!isset($data['application_id'], $data['status']))
      {
        throw new Exception("application_id and status are required");
      }
      return $this->application->updateStatus($data['application_id'], $data['status']);
    }

  }
?>
