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

    //must include a document id to get that document
    if (isset($_GET['tripId'])){
        //get the passed trip id
        $document->tripId = $_GET['tripId'];
        //execute the esarch
        $result = $document->getDocumentsForTrip();
        //count of results
        $num = $result->rowCount();
        if ($num>0) {
            //create array of results
            $doc_arr = array();
            while ($row = $result->fetch(PDO::FETCH_ASSOC)){
                extract($row);
                $doc_item = array(
                    'ID' => $ID,
                    'docName' => $DocFilePath,
                    'docTypeId' => $DocTypeId,
                    'docTypeName' => $DocumentTypeName,
                    'tripId' => $TripId,
                    'uploadedTime' => $UploadDatetime
                );
                //push to result array
                array_push($doc_arr, $doc_item);
            }

            //return result
            echo json_encode($doc_arr);
        }
    }

    else {
        print_r(json_encode(array('message' => 'Must pass tripId to retrieve documents for a trip!')));
        die(); //exit
    }