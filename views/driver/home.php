<?php
    // Initialize the session
    session_start();
    // Check if the user is not logged in and redirect to the login page
    if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"] === true){
        header("location: ../../index.php");
        exit;
    }

    $queryString = $_SESSION['id'];
    $ch = curl_init();
    #local
    #curl_setopt($ch, CURLOPT_URL, 'http://localhost/drive-and-doc/api/trips/?driverUserId=' . $queryString);
    #prod
    curl_setopt($ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/api/trips/?driverUserId=' . $queryString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch); //send the curl request
    curl_close($ch);
    $result = substr($result, 0, -3); //String ends in ? > for some reason. Might need to change this line later.
    $result = json_decode($result);

    $displayArr = array();
    if (isset($result) && (!isset($result->message))){ //Make sure trips exist from API call
        foreach($result as $x => $val) { //Began to populate displayArr with Trip Information
            if (isset($result[$x]->tripStatus) && $result[$x]->tripStatus == "Not Started"){ //Filter out completed trips
                array_push($displayArr, array($result[$x]->ID,
                $result[$x]->driverFirstName . ' ' . $result[$x]->driverLastName,
                date('m/d/Y g:i A', strtotime($result[$x]->startDateTime)),
                $result[$x]->startCity . ', ' . $result[$x]->startStateCode));
            }
        }
    }

        //Function to create HTML Table Element for Trips
        function create_table($headers = array(), $rows = array(), $attributes = array()){
            $headersCount = count($headers); //Header element count for "ID | Driver | ... " etc.
            $o = "<table "; //Start of Table Construction.
            if(!empty($attributes)){ //Attributes such as classes or styles
                foreach($attributes as $key =>$value){
                    $o .= "$key='" . $value . "' ";
                }
            }
            $o .= '>';
            $o .= '<tr>'; //Began adding the table elements
            foreach($headers as $heading){
                $o.= '<th>' . $heading . '</th>'; //Header Element such as "ID | Driver | ... " etc.
            }
            $o .= '</tr>';
            foreach($rows as $row){
                $o .= '<tr>'; //Data table elements
                for($i = 0; $i < count($row); $i++){
                    for ($col = 0; $col <= 3; $col++){
                        if ($col == 0){
                            $o .= "<td><a href = \"trip_detail.php?tripID=" . $row[$i][$col] ."\">" . $row[$i][$col] . "</a></td>" ; //If it's the first element, add <a> style
                        } else {
                            $o .= "<td>" . $row[$i][$col] . "</td>" ; //otherwise, just put in the data
                        }
                    }
                    $o .= '</tr>';
                }
            }
            return $o;
        }

    echo create_table( //Create Tables with information
        ["Trip ID","Driver","Start Date","Start Location"],
        [
            $displayArr
        ],
        [
            'class' => 'tripsTable'
        ]
        );
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Driver Home</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/stylesheet.css">
        <nav class = "topnav">
            <h2>Drive and Doc</h2>
            <a href="../../controllers/api/authentication/logout.php">
                <button id= "logoutButton" class="logoutButton">Logout</button>
            </a>
        </nav>
    </head>
    <body>
        <h1>Active Trips</h1>
        <h3><a href="past_trips.php">View Completed Trips</a></h3>
        <div class="tripsView">
            <h4>List of Active Trips</h4>           
            <!-- <table class="tripsTable">
                <tr> 
                    <th>Trip ID</th>
                    <th>Start Date</th>
                    <th>Start Location</th>
                    <th>Destination</th> 
                </tr>
                <tr>
                    <td><a href = "trip_detail.php?varname=<//?php echo $var_value ?>">0000001</a></td>
                    <td>9/17/2022</td>
                    <td>Topeka, KS</td>
                    <td>Fort Hays, KS</td>
                </tr>
                <tr>
                    <td><a href = "trip_detail.php">0000233</a></td>
                    <td>9/20/2022</td>
                    <td>Chicago, IL</td>
                    <td>St. Louis, MO</td>
                </tr>
                <tr>
                    <td><a href = "trip_detail.php">0000999</a></td>
                    <td>9/30/2022</td>
                    <td>Dallas,TX</td>
                    <td>Memphis, TN</td>
                </tr>
            </table> -->
        </div>
    </body>
</html>