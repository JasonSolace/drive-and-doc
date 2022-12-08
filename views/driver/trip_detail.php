<?php
    // Initialize the session
    session_start();
    // Check if the user is not logged in and redirect to the login page
    if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"] === true){
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

    function deleteDocu($docuID) {
        $delete_result = '';
        $delete_ch = curl_init();
        curl_setopt($delete_ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/controllers/api/documents/?docId=' . $docuID);
        curl_setopt($delete_ch, CURLOPT_CUSTOMREQUEST, "DELETE");
        curl_setopt($delete_ch, CURLOPT_RETURNTRANSFER, true);
        $delete_result = curl_exec($delete_ch);
        curl_close($delete_ch);
    }

?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Driver Trip Details</title>
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
        <h1>Trip Record Details</h1>
        <h3><a href="home.php">View Active Trips</a> | <a href="past_trips.php">View Completed Trips</a></h3>
            <div class="tripDetail">                
                <div class="tripDetailID"><strong>Trip ID</strong><?php echo '<br/>'. $result->ID; ?></div>
                <div class="tripDetailDriver"><strong>Driver</strong><?php echo '<br/>' . $result->driverFirstName . ' ' . $result->driverLastName; ?></div> 
                <div class="tripDetailArrivalTime"><strong>Expected Arrival</strong><?php echo '<br/>'. date('m/d/Y g:i A', strtotime($result->endDateTime)); ?></div>             
                <div class="tripDetailStartTime"><strong>Start Date</strong><?php echo '<br/>'. date('m/d/Y g:i A', strtotime($result->startDateTime)); ?></div>
                <div class="tripDetailStartLoc"><strong>Start Location</strong><?php echo '<br/>'. $result->startCity . ', ' . $result->startStateCode; ?></div>
                <div class="tripDetailDest"><strong>Destination</strong><?php echo '<br/>'. $result->endCity . ', ' . $result->endStatecode; ?></div>
            </div>
            <br>
                <div class="docHistHeaderDriver">
                    <h4>Document History</h4>
                    <form action = "upload.php?tripID=<?php echo $queryString?>" method="post">
                        <button type="submit" class="newDocBtn">Add New</button>
                    </form> 
                </div>
                <table class="docTable">
                    <tr>
                        <th>Document ID</th>
                        <th>Document Name</th>
                        <th>Document Type</th>
                        <th>Upload Date</th>
                        <th>Download</th>
                        <th>Delete</th>
                <?php
                if (isset($doc_result)){
                    for ($i = 0; $i < count($doc_result); $i++){
                        $row = $doc_result[$i];
                        echo "<tr>";
                        echo "<td>" . $row->ID . "</td>"; //Document ID
                        echo "<td>" . $row->docName . "</td>"; //Document Name
                        echo "<td>" . $row->docTypeName . "</td>"; //Document Type
                        echo "<td>" . date('m/d/Y g:i A', strtotime($row->uploadedTime)) . "</td>"; //When Document was uploaded

                        //Start of API call for Document Download URL
                        $dwnld_ch = curl_init();
                        #prod
                        curl_setopt($dwnld_ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/controllers/api/documents/?docId=' . $row->ID);
                        curl_setopt($dwnld_ch, CURLOPT_RETURNTRANSFER, TRUE);
                        $dwnld_result = curl_exec($dwnld_ch); //send the curl request
                        curl_close($dwnld_ch);
                        $dwnld_result = json_decode($dwnld_result);
                        echo "<td><a href=\"" . $dwnld_result->docURL . "\" title=\"" . $row->docTypeName . "\">"; //Create button for download URL
                        echo "<button class=\"docDownload\">Download</button></a>";

                        //Delete Button
                        if (isset($_POST['deleteDocu'])){
                            deleteDocu($row->ID);
                            unset($_POST['deleteDocu']);
                            header("Refresh:0");
                        }

                        echo "<form method=\"post\">";
                        echo "<td><button name=\"deleteDocu\" class=\"docDownload\">Delete</button>";
                        echo "</form>";
                    }
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
