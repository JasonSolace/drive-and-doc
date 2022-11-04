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
        header("location: ../../login.php");
        exit;
    }
    if(isset($_POST["createTripButton"])) {
        header("Location: trip_detail.php");
    }
    if(isset($_POST["createTripButton"])) {     
        header("Location: trip_details.php");
        exit();
    }
    if(isset($_POST["cancelButton"])) {
        header("Location: home.php");
        exit();
    }
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
            <form form action = "trip_detail.php" method="post" id="newTripForm">
                <label for="tripID">Trip ID: </label>
                <input type="text" id="tripID" name="tripID">
                <br>

                <label for="driverUserId">Driver ID: </label>
                <input type="text" id="driverUserId" name="driverUserId" required>
                <br>
                    
                <label for="tripCity">Start Location: </label>
                <input type="text" id="startCity" name="startCity">
                <br>
                    
                <label for="endCity">End Location: </label>
                <input type="text" id="endCity" name="endCity">
                <br>
                    
                <label for="startDateTime">Start Time: </label>
                <input type="datetime-local" id="startDateTime" name="startDateTime" required>
                <br>
                    
                <label for="endDateTime">End Time: </label>
                <input type="datetime-local" id="endDateTime" name="endDateTime">
                <br>                    

                <label for="loadContents">Load Contents: </label>
                <input type="text" id="loadContents" name="loadContents">
                <br>
                    
                <label for="loadWeight">Load Weight: </label>
                <input type="number" id="loadWeight" name="loadWeight">

                <!---<script>
                    $.ajax({
                        type:'POST',
                        url: '../../api/trips/index.php',
                        contentType: 'application/json; charset=utf-8',
                        data: {data:JSON.stringify($_POST)}
                    }).done(function ($_POST) {
                        self.result("Done!");
                    }).fail(showError);
                </script>-->
                    
                <button type="submit" class="cancelButton" formaction="home.php">Cancel</button>
                <button type="submit" class="createTripButton">Create Trip</button>
            </form>
        </div> 
    </body>
</html>