<?php
   require_once '../controllers/OfferController.php';

   $controller = new OfferController();

   $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
   $method = $_SERVER['REQUEST_METHOD'];

   header('Content-Type: application/json');  // All API responses will be JSON

   if($uri === '/api/offers' && $method === 'GET')
   {
     // $controller->index(); // Returns all offers as JSON
     $data = json_decode(file_get_contents('php://input'), true);
     $results = $controller->search($data['text'], $data['kind']);
     
   }
   else if ($uri === '/api/offers' && $method === 'POST')
   {
      $data = json_decode(file_get_contents('php://input'), true);
      $controller->create_offer($data);
   }
   else if(preg_match('#^/api/offers/(job|internship)/([^/]+)$#', $uri,$matches) && $method === 'PUT')
   {
     $data = json_decode(file_get_contents('php://input'), true);
     $type = $matches[2];
     $title = urldecode($matches[3]); // decode if url is encoded and handles spaces
     $controller->Update_Offer($type,$title,$data);
   }
   else if(preg_match('#^/api/offers/(job|internship)/([^/]+)$#', $uri, $matches) && $method === 'DELETE')
   {
     $type = $matches[2];
      $title = urldecode($matches[3]); // decode if url is encoded
      $controller->Delete_offer($type,$title);
   }
   





//    else if($uri === '/offers/internships' && $method === 'GET')
//    {
//     $controller->show('internship');
//    }
//    else if($uri === '/offers/jobs' && $method === 'GET')
//    {
//     $controller->show('job');
//    }
//    else if($uri === '/offers/create/job' &&  $method === 'GET')
//    {
//       $controller->createForm('job');
//    }
//    else if($uri === '/offers/create/internship' &&  $method === 'GET')
//    {
//       $controller->createForm('internship');
//    }
//    else if($uri === '/offers/store' && $method === 'POST')
//    {
//       $controller->create_offer($_POST);
//    }
//    else if(preg_match('#^/offers/edit/(\d+)$#', $uri,$matches) && $method === 'POST')
//    {
//       $controller->editForm($matches[1]);
//    }
//    else if(preg_match('#^/offers/update/(job|internship)/([^/]+)$#', $uri,$matches) && $method === 'POST')
//    {
//       $type = $matches[2];
//       $title = urldecode($matches[3]); // decode if url is encoded and handles spaces
//       $controller->Update_Offer($type,$title,$_POST);
//    }
//    elseif (preg_match('#^/offers/delete/(job|internship)/([^/]+)$#', $uri, $matches) && $method === 'POST')
//     {
//       $type = $matches[2];
//       $title = urldecode($matches[3]); // decode if url is encoded
//       $controller->Delete_offer($type,$title);
//    }