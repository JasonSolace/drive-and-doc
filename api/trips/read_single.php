<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');

    include_once '../../models/Trip.php';
    include_once '../../config/Database.php';
    
    //isntantiate db and connect
    $database = new Database();
    $db = $database->connect();

    //instantiate new trip object
    $trip = new Trip($db);

    //get passed data
    $data = json_decode(file_get_contents('php://input'));
   
    //assume ID is passed (trip ID) as it's conditional to arrive here
    $trip->id = $data->ID;
    //ensure the trip is valid
    if (!$trip->tripCheck()){
        //if an invalid id was passed return an error
        echo json_encode(array('message' => 'A Trip with this ID Was Not Found'));
        die();
    }

    //assume here we have returned with a result
    if ($trip->readOne()) {
        //return JSON of Trip result
        echo json_encode(
            array(
                'ID' => $trip->id,
                'tripStatus' => $trip->tripStatus,
                'startDateTime' => $trip->startDateTime,
                'endDateTime' => $trip->endDateTime,
                'startCity' => $trip->startCity,
                'startStateCode' => $trip->startStateCode,
                'endCity' => $trip->endCity,
                'endStatecode' => $trip->endStateCode,
                'driverUserId' => $trip->userId,
                'driverFirstName' => $trip->userFirstName,
                'driverLastName' => $trip->userLastName,
                'loadContents' => $trip->loadContents,
                'loadWeight' => $trip->loadWeight
            )
        );

    } else {
        echo json_encode(
            array('message'=>'No Matching Trips Found')
        );

    }



?>


















?>