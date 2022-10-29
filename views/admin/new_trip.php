<?php
    if(isset($_POST["createTripButton"])) {
        header("Location: trip_detail.php");
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

                <label for="driverID">Driver ID: </label>
                <input type="text" id="driverID" name="driverID">
                <br>
                    
                <label for="tripStartLoc">Start Location: </label>
                <input type="text" id="tripStartLoc" name="tripStartLoc">
                <br>
                    
                <label for="tripDestination">End Location: </label>
                <input type="text" id="tripDestination" name="tripDestination">
                <br>
                    
                <label for="tripStartTime">Start Time: </label>
                <input type="datetime-local" id="tripStartTime" name="tripStartTime">
                <br>
                    
                <label for="tripEndTime">End Time: </label>
                <input type="datetime-local" id="tripEndTime" name="tripEndTime">
                <br>                    

                <label for="tripLoadContents">Load Contents: </label>
                <input type="text" id="tripLoadContents" name="tripLoadContents">
                <br>
                    
                <label for="tripLoadWeight">Load Weight: </label>
                <input type="number" id="tripLoadWeight" name="tripLoadWeight">
                    
                <button type="submit" class="cancelButton" formaction="home.php">Cancel</button>
                <button type="submit" class="createTripButton">Create Trip</button>
            </form>
        </div> 
    </body>
</html>