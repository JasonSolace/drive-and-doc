<?php
    // Initialize the session
    session_start();
    // Check if the user is already logged in, if yes then redirect them to home page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        if(isset($_SESSION["usertype"])) {
            if ($_SESSION["usertype"] === 1) { // user is driver
                header("location: ../driver/home.php");
            exit();
            }
        }
    } else {
        header("location: ../../index.php");
        exit;
    }

    if (isset($_GET['queryStr'])) {
        //function to handle search, assuming the search bar is populated with something
        $queryString = filter_input(INPUT_GET, 'queryStr', FILTER_SANITIZE_STRING); //clean the input string
        $ch = curl_init(); //create a curl request

        #local
        #curl_setopt($ch, CURLOPT_URL, 'http://localhost/drive-and-doc/controllers/api/trips/?queryStr=' . $queryString);//define url as api target, must change to prod
        #prod
        curl_setopt($ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/controllers/api/trips/?queryStr=' . $queryString);//define url as api target, must change to prod
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $queryResult = curl_exec($ch);//send the curl request
        curl_close($ch);
        $queryResult = json_decode($queryResult);
    }

    //Began API call
    $userId = $_SESSION['id'];
    #echo $userId;
    $ch = curl_init();

    #local
    #curl_setopt($ch, CURLOPT_URL, 'http://localhost/drive-and-doc/controllers/api/trips/?userId=' . $userId);
    #prod
    curl_setopt($ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/controllers/api/trips/?userId=' . $userId);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch); //send the curl request
    curl_close($ch);
    $result = json_decode($result);
    //End of API call

    $displayArr = array();
    if (isset($result) && (!isset($result->message))){ //Make sure trips exist from API call
        foreach($result as $x => $val) { //Began to populate displayArr with Trip Information
            if (isset($result[$x]->tripStatus) && $result[$x]->tripStatus != "Not Started"){ //Filter out completed trips
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
        if (isset($displayArr) && !isset($queryResult)){
            echo create_table( //Create Tables with information
                ["Trip ID","Driver","Start Date","Start Location"],
                [
                    $displayArr
                ],
                [
                    'class' => 'tripsTable'
                ]
                );

            }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Admin Past Trips</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/stylesheet.css">
        <nav class = "adminnav">
            <form action = "new_trip.php" method="post">
                <button type="submit" id= "tripButton" class="tripButton">Create A Trip</button>
            </form>
            <h2>Drive and Doc</h2>
            <a href="../../controllers/api/authentication/logout.php">
                <button id= "logoutButton" class="logoutButton">Logout</button>
            </a>
        </nav>
    </head>
    <body>
        <h1>Completed Trips</h1>
        <h3><a href="home.php">View Active Trips</a></h3>
        <div class="searchContainer">
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get"> <!-- action = '..\..\api\trips\read.php'  method='get' >--> 
                <input type="text" placeholder="Trip Record" class="search" name="queryStr">
                <button type="submit" class="searchButton">Search</button>
            </form>
        </div>
        <div class="tripsView">
            <h4>List of Completed Trips</h4>           
            <?php

                if (isset($queryResult) && is_array($queryResult)) {
                    //make an html table with search results
                    //remove old table result
                    echo '<table class="tripsTable">';
                    echo '<tr>';
                    echo '<th>Trip ID</th>';
                    echo '<th>Driver</th>';
                    echo '<th>Start Date</th>';
                    echo '<th>Start Location</th>';
                    echo '</tr>';
                    for ($i = 0; $i < count($queryResult); $i++) {
                        $row = $queryResult[$i];
                        #echo $row;
                        echo "<tr>";
                        echo "<td><a href = \"trip_detail.php?tripID=" . $row->ID . "\">" . $row->ID . "</a></td>"; //Hyperlink for trip details for a specific trip once search is made
                        echo "<td>" . $row->driverFirstName . ' ' . $row->driverLastName . "</td>";
                        echo "<td>" . $row->startDateTime . "</td>";
                        echo "<td>" . $row->startCity . ', ' . $row->startStateCode . "</td>";
                        echo "</tr>";
                    }
                    echo '</table>';
                }
                else if (isset($queryResult)) {
                    //indicate that no results were returned
                    echo "No Results Found";
                }
            ?>

        </div>
    </body>
</html>