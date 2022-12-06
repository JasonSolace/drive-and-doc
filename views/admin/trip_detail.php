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

    $doc_ch = curl_init();
    #prod
    curl_setopt($doc_ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/controllers/api/documents/?tripId=' . $queryString);
    curl_setopt($doc_ch, CURLOPT_RETURNTRANSFER, TRUE);
    $doc_result = curl_exec($doc_ch); //send the curl request
    curl_close($doc_ch);
    $doc_result = json_decode($doc_result);
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
                <div class="editTrip">
                    <form action = "edit_trip.php" method="post">
                        <button type="submit" id= "editButton" class="editButton">Edit Trip Details</button>
                    </form>
                </div>
            </div>
                <div class="docHistHeader">
                    <h4>Document History</h4>
                    <form action = "upload.php?tripID=<?php echo $queryString?>" method="post">
                        <button type="submit" class="newDocBtn">Add New</button>
                    </form> 
                </div>
                <table class="docTable">
                    <tr>
                        <th>Document Type</th>
                        <th>Upload Date</th>
                        <th>Download</th>
                    </tr>
                <?php
                    for ($i = 0; $i < count($doc_result); $i++){
                        $row = $doc_result[$i];
                        echo "<tr>";
                        echo "<td>" . $row->docTypeName . "</td>";
                        echo "<td>" . date('m/d/Y g:i A', strtotime($row->uploadedTime)) . "</td>";

                        $dwnld_ch = curl_init();
                        #prod
                        curl_setopt($dwnld_ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/controllers/api/documents/?docId=' . $row->ID);
                        curl_setopt($dwnld_ch, CURLOPT_RETURNTRANSFER, TRUE);
                        $dwnld_result = curl_exec($dwnld_ch); //send the curl request
                        curl_close($dwnld_ch);
                        $dwnld_result = json_decode($dwnld_result);
                        echo "<td><a href=\"" . $dwnld_result->docURL . "\" title=\"" . $row->docTypeName . "\">";
                        echo "<button <class=\"docDownload\">Download</button></a>";
                        echo "</tr>";
                    }
                ?>
                    <!---
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
                    --->
                </table>
            </div>
    </body>
</html>
