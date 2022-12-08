<?php
    $queryString = $_GET['tripID'];
    $ch = curl_init();
    #local
    #curl_setopt($ch, CURLOPT_URL, 'http://localhost/drive-and-doc/controllers/api/trips/?ID=' . $queryString);
    #prod
    curl_setopt($ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/controllers/api/trips/?ID=' . $queryString);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    $result = curl_exec($ch); //send the curl request
    curl_close($ch);
    $result = json_decode($result);
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
        <h1>Edit Trip Details</h1>
        <h3><a href="home.php">View Active Trips</a> | <a href="past_trips.php">View Completed Trips</a></h3>
        <div class="createTrip">
            <form form action = "../../controllers/api/trips/update.php/" method="POST" id="newTripForm">
                <input type="hidden" name="_METHOD" value="PUT">
                <div class = "tripID">
                    <label for="ID">Trip ID: </label>
                    <input type="hidden" id="ID" name="ID" value="<?php echo ' '. $result->ID; ?>"> <?php echo ' '. $result->ID; ?>
                </div>
                <br>

                <label for="tripStatus">Trip Status: </label>
                <input type="text" id="tripStatus" name="tripStatus" value="<?php echo ''. $result->tripStatus; ?>">
                <br>

                <label for="companyId">Company ID: </label>
                <input type="text" id="companyID" name="companyID" value="<?php echo ''. $result->companyId; ?>">
                <br>

                <label for="driverUserId">Driver ID: </label>
                <input type="text" id="driverUserId" name="driverUserId" value="<?php echo ''. $result->driverUserId; ?>">
                <br>
                    
                <label for="startCity">Start Location: </label>
                <input type="text" id="startCity" name="startCity" value="<?php echo ''. $result->startCity; ?>">
                <br>

                <label for="startStateCode">Start State: </label>
                <input type="text" id="startStateCode" name="startStateCode" value="<?php echo ''. $result->startStateCode; ?>">
                <br>
                    
                <label for="endCity">End Location: </label>
                <input type="text" id="endCity" name="endCity" value="<?php echo ''. $result->endCity; ?>">
                <br>

                <label for="endStateCode">End State: </label>
                <input type="text" id="endStateCode" name="endStateCode" value="<?php echo ''. $result->endStatecode; ?>">
                <br>
                    
                <label for="startDatetime">Start Time: </label>
                <input type="datetime-local" id="startDatetime" name="startDatetime" value="<?php echo date('Y-m-d\TH:i:s', strtotime($result->startDateTime)); ?>">
                <br>
                    
                <label for="endDatetime">End Time: </label>
                <input type="datetime-local" id="endDatetime" name="endDatetime" value="<?php echo date('Y-m-d\TH:i:s', strtotime($result->endDateTime)); ?>">
                <br>                    

                <label for="loadContents">Load Contents: </label>
                <input type="text" id="loadContents" name="loadContents" value="<?php echo ''. $result->loadContents; ?>">
                <br>
                    
                <label for="loadWeight">Load Weight: </label>
                <input type="number" id="loadWeight" name="loadWeight" value="<?php echo ''. $result->loadWeight; ?>">
                    
                <button type="submit" class="cancelButton" formaction="<?php echo 'trip_detail.php?tripID=' . $result->ID; ?>" formnovalidate>Cancel</button>
                <button type="submit" class="createTripButton">Update Trip</button>
            </form>
        </div> 
    </body>
</html>