<?php
    // Initialize the session
    session_start();
    // Check if the user is not logged in and redirect to the login page
    if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"] === true){
        header("location: ../../login.php");
        exit;
    }

    //Function to create HTML Table Element for Trips
    function create_table($headers = array(), $rows = array(), $attributes = array()){
        $headersCount = count($headers); //Header element, such as "ID | Driver | ... " etc.
        $o = "<table "; //Start of Table Construction. Make sure it's not empty:
        if(!empty($attributes)){
            foreach($attributes as $key =>$value){
                $o .= "$key='" . $value . "' ";
            }
        }
        $o .= '>';
        $o .= '<tr>';
        foreach($headers as $heading){
            $o.= '<th>' . $heading . '</th>';
        }
        $o .= '</tr>';
        foreach($rows as $row){
            $o .= '<tr>';
            for($i = 0; $i <= $headersCount - 1; $i++){
                for ($col = 0; $col <= 3; $col++){
                    $o .= " <td>" . $row[$i][$col] . "</td>" ;
                }
                $o .= '</tr>';
            }
        }
        return $o;
    }

    //read_driver_trips copy/paste start
    include_once '../../models/Trip.php';
    include_once '../../config/Database.php';
    
    //isntantiate db and connect
    $database = new Database();
    $db = $database->connect();

    //instantiate new trip object
    $trip = new Trip($db);
   
    //We must have a driver id to get here, so assume it's in place
    $trip->userId = '8';

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

    //create array of results
    $trip_arr = array();
    if ($num>0) {
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){
            extract($row);
            //returned result name => query column name
            $trip_item = array( //Removed unneeded trip values
                'ID' => $ID,
                'startDateTime' => $StartDateTime,
                'startCity' => $StartCity,
                'startStateCode' => $StartStateCode,
                'driverFirstName' => $FirstName,
                'driverLastName' => $LastName,
            );

            //push to result array
            array_push($trip_arr, $trip_item);
        }
        //return result array
       //echo json_encode($trip_arr);
       
    } 
    else {  
        echo json_encode(
            array('message'=>'No Matching Trips Found')
        );
    }
    //End of Copy/Paste Driver Trip Edit

$displayArr = array(); //Create Array to populate tables

foreach($trip_arr as $x => $val) { //Began to populate displayArr with Trip Information
    array_push($displayArr, array($trip_arr[$x]['ID'],
    $trip_arr[$x]['driverFirstName'] . ' ' . $trip_arr[$x]['driverLastName'],
    $trip_arr[$x]['startDateTime'],
    $trip_arr[$x]['startCity'] . ', ' . $trip_arr[$x]['startStateCode']));
}       
                            

    echo create_table( //Create Tables with information
        ["Trip ID","Driver","Start Date","Start Location"],
        [
            $displayArr
        ],
        [
            'class' =>'tripsTable'
        ]
    );

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Driver Past Trips</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/stylesheet.css">
        <nav class = "topnav">
            <h2>Drive and Doc</h2>
            <a href="../../logout.php">
                <button id= "logoutButton" class="logoutButton">Logout</button>
            </a>
        </nav>
    </head>
    <body>
        <h1>Completed Trips</h1>
        <h3><a href="home.php">View Active Trips</a></h3>
        <div class="tripsView">
            <h4>List of Completed Trips</h4>           
            <table class="tripsTable">
                <tr><!--examples until functionality in place-->
                    <th>Trip ID</th>
                    <th>Driver</th>
                    <th>Start Date</th>
                    <th>Start Location</th>
                </tr>
                <tr>
                    <td><a href = "">0000100</a></td>
                    <td>2/17/2022</td>
                    <td>Boise, ID</td>
                    <td>Portland, OR</td>
                </tr>
                <tr>
                    <td><a href>0000300</a></td>
                    <td>1/20/2022</td>
                    <td>Montgomery, AL</td>
                    <td>Mobile, AL</td>
                </tr>
                <tr>
                    <td><a href>0001999</a></td>
                    <td>3/30/2022</td>
                    <td>Boulder, CO</td>
                    <td>Denver, CO</td>
                </tr>
            </table> 
        </div>
    </body>
</html>