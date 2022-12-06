<?php
       //headers
       header('Access-Control-Allow-Origin: *');
       header('Content-Type: application/json');
       header('Access-Control-Allow-Methods: POST');
       header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Authorization,X-Requested-With');
       
       include_once '../../../config/Database.php';
       include_once '../../../config/S3Bucket.php';
       include_once '../../../models/Document.php'; 

       $database = new Database();
       $db = $database->connect();
   
       $s3bucket = new S3Bucket();
       $s3 = $s3bucket->connect();
   
       $document = new Document($db, $s3);

       //DELETE trip requiers a Document ID
       if (isset($_GET['docId'])){
                $document->ID = $_GET['docId'];
                $document->delete();
            }
        else {
            print_r(json_encode(array('message' => 'No docId Passed')));
            die(); //exit
        }




?>