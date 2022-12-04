<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Authorization,X-Requested-With');
    
    include_once '../../../config/Database.php';
    include_once '../../../config/S3Bucket.php';
    include_once '../../../models/Document.php';  

    $database = new Database();
    $db = $database->connect();

    $s3bucket = new S3Bucket();
    $s3 = $s3bucket->connect();

    $document = new Document($db, $s3);

    //this needs to be the name of the file in the S3 bucket
    $key = $_GET['IMG_NAME'];
    $bucket = 'drive-and-doc';

    try {
        //Creating a presigned URL
        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => 'drive-and-doc',
            'Key' => $key
        ]);

        $request = $s3->createPresignedRequest($cmd, '+20 minutes');

        // Get the actual presigned-url
        $presignedUrl = (string)$request->getUri();
        print_r($presignedUrl);
    }
    catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }
