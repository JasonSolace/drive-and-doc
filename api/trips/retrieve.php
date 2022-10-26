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

    //ensure a query string is passed
    if (isset($data->queryString)) {
        $data->queryString = '%' . $data->queryString . '%' ;//add % for LIKE statement
        $trip->queryStringId = $data->queryString;
        $trip->queryStringStatus = $data->queryString;
        $trip->queryStringStartCity = $data->queryString;
        $trip->queryStringStartStateCode = $data->queryString;
        $trip->queryStringEndCity = $data->queryString;
        $trip->queryStringEndStateCode = $data->queryString;
        $trip->queryStringUserFirstName = $data->queryString;
        $trip->queryStringUserLastName = $data->queryString;
        $trip->queryStringLoadContents = $data->queryString;
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
                'TripStatus' => $TripStatus,
                'StartDateTime' => $StartDateTime,
                'EndDateTime' => $EndDateTime,
                'StartCity' => $StartCity,
                'StartStateCode' => $StartStateCode,
                'EndCity' => $EndCity,
                'EndStateCode' => $EndStateCode,
                'UserId' => $UserId,
                'DriverFirstName' => $FirstName,
                'DriverLastName' => $LastName,
                'LoadContents' => $LoadContents,
                'loadWeight' => $LoadWeight
            );

            //push to result array
            array_push($trip_arr, $trip_item);
        }
        //return result array
        echo json_encode($trip_arr);

    } else {
        echo json_encode(
            array('message'=>'No Matching Trips Found')
        );
}



















?>