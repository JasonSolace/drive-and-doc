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
    if (isset($_GET['queryStr'])) {    
        $queryString = $_GET['queryStr'];
        $queryString = '%' . $queryString . '%' ;//add % for LIKE statement
        $trip->queryStringId = $queryString;
        $trip->queryStringStatus = $queryString;
        $trip->queryStringStartCity = $queryString;
        $trip->queryStringStartStateCode = $queryString;
        $trip->queryStringEndCity = $queryString;
        $trip->queryStringEndStateCode = $queryString;
        $trip->queryStringUserFirstName = $queryString;
        $trip->queryStringUserLastName = $queryString;
        $trip->queryStringLoadContents = $queryString;
        $result = $trip->searchTrip();
    }
    //add some handling for no query string passed
    else {
        print_r(json_encode(array('message' => 'No Query String Passed')));
        die(); //exit
    }


    //assume here we have returned with a result
    $num = $result->rowCount();
    #print_r($result->fetch(PDO::FETCH_ASSOC));
    //if we have results
    if ($num>0) {
        //create array of results
        $trip_arr = array();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            //returned result name => query column name
            $trip_item = array(
                'ID' => $ID,
                'tripStatus' => $TripStatus,
                'startDateTime' => $StartDateTime,
                'endDateTime' => $EndDateTime,
                'startCity' => $StartCity,
                'startStateCode' => $StartStateCode,
                'endCity' => $EndCity,
                'endStateCode' => $EndStateCode,
                'driverUserId' => $UserId,
                'driverFirstName' => $FirstName,
                'driverLastName' => $LastName,
                'loadContents' => $LoadContents,
                'loadWeight' => $LoadWeight
            );

            //push to result array
            array_push($trip_arr, $trip_item);
        }
        //return result array
        echo json_encode($trip_arr);
        } 
    else {
        echo json_encode(
            array('message'=>'No Matching Trips Found')
        );
    }



















?>