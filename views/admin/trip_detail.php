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

    if(isset($_POST["tripButton"])) {
        header("Location: new_trip.php");
        exit();
    }
    $queryString = $_GET['tripID'];
    $ch = curl_init();
    #local
    #curl_setopt($ch, CURLOPT_URL, 'http://localhost/drive-and-doc/api/trips/?ID=' . $queryString);
    #prod
    curl_setopt($ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/api/trips/?ID=' . $queryString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch); //send the curl request
    curl_close($ch);
    $result = substr($result, 0, -3); //String ends in ? > for some reason. Might need to change this line later.
    $result = json_decode($result);


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Admin Trip Details</title>
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
        <h1>Trip Record Details</h1>
        <h3><a href="home.php">View Active Trips</a> | <a href="past_trips.php">View Completed Trips</a></h3>
            <div class="tripDetailAdmin">                
            <div class="tripDetailID"><strong>Trip ID</strong><?php echo '<br/>'. $result->ID; ?></div>
                <div class="tripDetailDriver"><strong>Driver</strong><?php echo '<br/>' . $result->driverFirstName . ' ' . $result->driverLastName; ?></div> 
                <div class="tripDetailArrivalTime"><strong>Expected Arrival</strong><?php echo '<br/>'. date('m/d/Y g:i A', strtotime($result->endDateTime)); ?></div>             
                <div class="tripDetailStartTime"><strong>Start Date</strong><?php echo '<br/>'. date('m/d/Y g:i A', strtotime($result->startDateTime)); ?></div>
                <div class="tripDetailStartLoc"><strong>Start Location</strong><?php echo '<br/>'. $result->startCity . ', ' . $result->startStateCode; ?></div>
                <div class="tripDetailDest"><strong>Destination</strong><?php echo '<br/>'. $result->endCity . ', ' . $result->endStatecode; ?></div>
                <div class="completeTrip"><button class="completeTripButton">Mark As Completed</button></div>
            </div>
                <div class="docHistHeader">
                    <h4>Document History</h4>
                    <button class="newDocBtn">Add New</button>
                </div>
                <table class="docTable">
                    <tr>
                        <th>Document Type</th>
                        <th>Upload Date</th>
                        <th>Download</th>
                    </tr>
                    <tr>
                        <td>Load Permit</td>
                        <td>9-17-2022<br>10:00 AM</td>
                        <td><button type="submit" class="docDownload">Download</button></td>
                    </tr> 
                    <tr>
                        <td>Trip Log</td>
                        <td>9-18-2022<br>8:00 AM</td>
                        <td><button type="submit" class="docDownload">Download</button></td>
                    </tr>
                </table>
            </div>
    </body>
</html>