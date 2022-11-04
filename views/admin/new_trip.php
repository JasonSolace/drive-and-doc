<?php
    // Initialize the session
    /*session_start();
    // Check if the user is already logged in, if yes then redirect them to home page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        if(isset($_SESSION["usertype"])) {
            if ($_SESSION["usertype"] === 1) { // user is driver
                header("location: ../driver/home.php");
            exit();
            }
        }
    } else {
        header("location: ../../login.php");
        exit;
    }*/
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
        </nav>
    </head>
    <body>
        <h1>Create A New Trip</h1>
        <h3><a href="home.php">View Active Trips</a> | <a href="past_trips.php">View Completed Trips</a></h3>
        <div class="createTrip">
            <form form action = "../../controllers/api/trips/index.php" method="post" id="newTripForm">
                <label for="tripID">Trip ID: </label>
                <input type="text" id="tripID" name="tripID">
                <br>

                <label for="tripStatus">Trip Status: </label>
                <input type="text" id="tripStatus" name="tripStatus">
                <br>

                <label for="companyId">Company ID: </label>
                <input type="text" id="companyId" name="companyId">
                <br>

                <label for="driverUserId">Driver ID: </label>
                <input type="text" id="driverUserId" name="driverUserId" required>
                <br>
                    
                <label for="startCity">Start Location: </label>
                <input type="text" id="startCity" name="startCity">
                <br>

                <label for="startStateCode">Start State Abbr: </label>
                <input type="text" id="startStateCode" name="startStateCode">
                <br>
                    
                <label for="endCity">End Location: </label>
                <input type="text" id="endCity" name="endCity">
                <br>

                <label for="endStateCode">End State Abbr: </label>
                <input type="text" id="endStateCode" name="endStateCode">
                <br>
                    
                <label for="startDatetime">Start Time: </label>
                <input type="datetime-local" id="startDatetime" name="startDatetime" required>
                <br>
                    
                <label for="endDatetime">End Time: </label>
                <input type="datetime-local" id="endDatetime" name="endDatetime">
                <br>                    

                <label for="loadContents">Load Contents: </label>
                <input type="text" id="loadContents" name="loadContents">
                <br>
                    
                <label for="loadWeight">Load Weight: </label>
                <input type="number" id="loadWeight" name="loadWeight">
                    
                <button type="submit" class="cancelButton" formaction="home.php">Cancel</button>
                <button type="submit" class="createTripButton">Create Trip</button>
            </form>
        </div> 
    </body>
</html>