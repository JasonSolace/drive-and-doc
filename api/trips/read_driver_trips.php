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
   
    //We must have a driver id to get here, so assume it's in place
    $trip->userId = $data->driverUserId;

    //ensure the user is valid
    if (!$trip->userCheck()){
        //if an invalid id was passed return an error
        echo json_encode(array('message' => 'A User with this ID Was Not Found'));
        die();
    }

    #execute the search
    $result = $trip->readOneDriver();
    //assume here we have returned with a result
    $num = $result->rowCount();
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


















?>