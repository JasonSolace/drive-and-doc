<?php
       //headers
       header('Access-Control-Allow-Origin: *');
       header('Content-Type: application/json');
       header('Access-Control-Allow-Methods: POST');
       header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Authorization,X-Requested-With');
       
       include_once '../../../config/Database.php';
       include_once '../../../models/Trip.php';

       $database = new Database();
       $db = $database->connect();

       $trip = new Trip($db);

        $trip->userId = is_int($_POST['driverUserId']) ? $_POST['driverUserId'] : intval($_POST['driverUserId']);                
        $trip->tripStatus = $_POST['tripStatus'];
        $trip->startDateTime = $_POST['startDatetime'];
        $trip->endDateTime = $_POST['endDatetime'];
        $trip->startCity = $_POST['startCity'];
        $trip->startStateCode = $_POST['startStateCode'];
        $trip->endCity = $_POST['endCity'];
        $trip->endStateCode = $_POST['endStateCode'];
        $trip->loadContents = $_POST['loadContents'];
        $trip->loadWeight = $_POST['loadWeight'];
        $trip->companyId = $_POST['companyId'];
                
        //test if passed user id is in the db
        if (!$trip->userCheck()){
            //user not in the database
            echo json_encode(array('message' => 'driverUserId Not Found'));
            die();
        }
        //assume here passed user id is in the database, and passed date string is of valid format
        else if ($trip->create()){
            //if trip creation is successful, return the Trip
            header("Location: ../../../views/admin/trip_detail.php");
            exit;
        }
        else {
            echo json_encode(
            array('message' => 'Trip not created')
            );
        }