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

    //make sure a file is sent with the request as property "image"
    if (isset($_FILES['image']) && $_FILES['image']['error']==0){
        $allowed = array('jpg' => 'image/jpg',
                         'jpeg' => 'image/jpeg',
                         'giv' => 'image/gif',
                         'png' => 'image/png');
        $filename = $_FILES['image']['name'];
        $filetype = $_FILES['image']['type'];


        //check if invalid file format sent
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)){
            print_r(json_encode(array('message' => 'Incorrect file format, document must be png/jpg/jpeg/gif')));
            die();//exit
        }


        //check that upload file is valid and provided by POST upload mechanism
        if(move_uploaded_file($_FILES['image']['tmp_name'], $filename)){
            $document->uploadedTime = gmdate('Y-m-d H:i:s'); //utc time for now
            $document->tripId = isset($_POST['tripId']) ? $_POST['tripId'] : $_GET['tripId'];
            $document->docTypeId = isset($_POST['docTypeId']) ? $_POST['docTypeId'] : $_GET['docTypeId'];
            $document->filename = $filename;

            //check that the trip and doc type exist so we don't violate constraints
            if (!$document->tripCheck()){
                echo json_encode(array('message' => 'tripId Not Found'));
                die();
            }
            if (!$document->docTypeCheck()){
                echo json_encode(array('message' => 'tripId Not Found'));
                die();
            }           
            
            //if these are good, call the upload method
            $document->upload();
        }
        else {
            print_r(json_encode(array('message' => 'File not sent with HTTP POST request.')));
            die();
        }
    }
    else {
        print_r(json_encode(array('message' => 'No file included with request image property.')));
        die();
    }
