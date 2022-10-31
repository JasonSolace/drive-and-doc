<?php
    $tripID = $_POST['tripID'];
    $driverID = $_POST['driverID'];
    $tripStartLoc = $_POST['tripStartLoc'];
    $tripDestination = $_POST['tripDestination'];
    $tripStartTime = $_POST['tripStartTime'];
    $tripEndTime = $_POST['tripEndTime'];
    $tripLoadContents = $_POST['tripLoadContents'];
    $tripLoadWeight = $_POST['tripLoadWeight'];

    if(isset($_POST["tripButton"])) {
        header("Location: new_trip.php");
        exit();
    }
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
            <form action = "../../index.php" method="post">
                <button type="submit" id= "logoutButton" class="logoutButton">Logout</button>
            </form>
        </nav>
    </head>
    <body>
        <h1>Trip Record Details</h1>
        <h3><a href="home.php">View Active Trips</a> | <a href="past_trips.php">View Completed Trips</a></h3>
            <div class="tripDetailAdmin">                
                <div class="tripDetailID"><strong>Trip ID</strong><?php echo '<br/>'. $tripID; ?> </div>
                <div class="tripDetailDriver"><strong>Driver</strong><?php echo '<br/>'. $driverID; ?></div> 
                <div class="tripDetailArrivalTime"><strong>Expected Arrival</strong><?php echo '<br/>'. date('m/d/Y g:i A', strtotime($tripEndTime)); ?></div>             
                <div class="tripDetailStartTime"><strong>Start Date</strong><?php echo '<br/>'. date('m/d/Y g:i A', strtotime($tripStartTime)); ?></div>
                <div class="tripDetailStartLoc"><strong>Start Location</strong><?php echo '<br/>'. $tripStartLoc; ?></div>
                <div class="tripDetailDest"><strong>Destination</strong><?php echo '<br/>'. $tripDestination; ?></div>
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