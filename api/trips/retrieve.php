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

    //ensure a query string is passed
    if (isset($_GET['queryString']) && $_GET['queryString'] != '') {
        
        
        $trip->queryString = $_GET['queryString'];
        $result = $trip->searchTrip();
    }
    //add some handling for no query string passed



    //assume here we have returned with a result
    $num = $result->rowCount();
    //if we have results
    if ($num>0) {
        //create array of results
        $trip_arr = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            $trip_item = array(
                'ID' => $id,
                'TripStatus' => $tripStatus,
                'StartDateTime' => $startDateTime,
                'EndDateTime' => $endDateTime,
                'StartCity' => $startCity,
                'StartStateCode' => $startStateCode,
                'EndCity' => $endCity,
                'EndStateCode' => $endStateCode,
                'UserId' => $userId,
                'FirstName' => $userFirstName,
                'LastName' => $userLastName,
                'LoadContents' => $loadContents,
                'loadWeight' => $loadWeight
            );

            //push to data
            array_push($trip_arr, $trip_item);
        }

    } else {
        echo json_encode(
            array('message'=>'No Matching Trips Found')
        );
}



















?>