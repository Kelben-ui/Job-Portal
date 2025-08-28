<?php
  
   require_once "D:/Xampp/htdocs/JobPortal/app/models/Offers.php";
   require_once "D:/Xampp/htdocs/JobPortal/app/helpers/InputHelper.php";

   class OfferController
   {
    private $model;

    public function __construct()
    {
        $this->model = new Offer();
    }

    public function index()
    {
        $Offers = $this->model->Read_All_Offers();
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $Offers]);
    }

    // public function show($Offer_type)
    // {
    //     $Offers = $this->model->Read_offer($Offer_type);
    //     include 'views/offers/show.php';
    // }

    // public function createForm($type)
    // {
    //     include 'views/offers/create_$type.php';
    // }

    public function create_offer($data)
    {
        $data['offer_title'] = InputHelper::sanitizeString($data['offer_title']);
        $data['Description'] = InputHelper::sanitizeString($data['Description']);
        $data['Requirements'] = InputHelper::sanitizeString($data['Requirements']);
        $data['location'] = InputHelper::sanitizeString($data['location']);
        $data['Salary'] = InputHelper::sanitizeString($data['Salary']);
        $data['Deadline'] = InputHelper::sanitizeString($data['Deadline']);
        $data['Status'] = InputHelper::sanitizeString($data['Status']);
        $data['Offer_type'] = InputHelper::sanitizeString($data['Offer_type']);

        if($this->model->create_offer($data))
        {
            http_response_code(201);
            echo json_encode(['status' => 'success', 'message' => 'Offer created']);
        }
        else
        {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Failed to create']);
        }
        
    }

    // public function editForm($id)
    // {
    //     $offers = $this->model->getById($_SESSION['email'],$id);
    //     include "views/offers/edit.php";
    // }

    public function Update_Offer($Offer_type,$Offer_title,$data)
    {
        $Offer_type = InputHelper::sanitizeString($offer_type);
        $Offer_title = InputHelper::sanitizeString($Offer_title);
        $data['title'] = InputHelper::sanitizeString($data['title']);
        $data['description'] = InputHelper::sanitizeString($data['description']);
        $data['requirements'] = InputHelper::sanitizeString($data['requirements']);
        $data['location'] = InputHelper::sanitizeString($data['location']);
        $data['salary'] = InputHelper::sanitizeString($data['salary']);
        $data['deadline'] = InputHelper::sanitizeString($data['deadline']);
        $data['Status'] = InputHelper::sanitizeString($data['Status']);

        if($this->model->Update_Offer($_SESSION['email'],$Offer_type,$Offer_title,$data))
        {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'offer updated']);
        }
        else{
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Update failed']);
        }
    }

    public function Delete_offer($Offer_type,$Offer_title)
    {
        $Offer_type = InputHelper::sanitizeString($offer_type);
        $Offer_title = InputHelper::sanitizeString($Offer_title);
        
        if($this->model->Delete_offer($_SESSION['email'],$Offer_type,$Offer_title))
        {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'message' => 'Offer deleted!']);
        }
        else
        {
            http_response_code(500);
            echo json_encode(['status' => 'error', 'message' => 'Delete failed']);
        }
        
    }

    public function search(string $q = '', string $kind = 'all') {
        $data = json_decode(file_get_contents('php://input'), true);
        $q = isset($data['text']) ? $data['text'] : ($data['keyword'] ?? '');
        $kind = isset($data['kind']) ? $data['kind'] : ($data['type'] ?? 'all');

        $map = ['jobs' => 'job', 'internships' => 'internship'];
        $lk = strtolower(trim($kind));
        if(isset($map[$lk]))
        {
            $kind = $map[$lk];
        }
        $results = $this->model->Search_offers($q, $kind);
        http_response_code(200);
        echo json_encode(['status' => 'success', 'data' => $results]);
    }
   }

   
?> 