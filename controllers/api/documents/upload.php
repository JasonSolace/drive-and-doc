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
    


?>