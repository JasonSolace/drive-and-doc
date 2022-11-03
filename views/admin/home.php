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
        exit();
    }

    if(isset($_POST["tripButton"])) {
        header("Location: new_trip.php");
        exit();
    }

    if (isset($_GET['queryStr'])) {
        //function to handle search, assuming the search bar is populated with something
        $queryString = filter_input(INPUT_GET, 'queryStr', FILTER_SANITIZE_STRING); //clean the input string
        $ch = curl_init(); //create a curl request

        #local
        curl_setopt($ch, CURLOPT_URL, 'http://localhost/drive-and-doc/api/trips/?queryStr=' . $queryString);//define url as api target, must change to prod
        #prod
        #curl_setopt($ch, CURLOPT_URL, 'http://drive-and-doc.herokuapp.com/api/trips/?queryStr=' . $queryString);//define url as api target, must change to prod
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        $result = curl_exec($ch);//send the curl request
        curl_close($ch);
        $result = json_decode($result);
        #echo(var_dump($result[0]->ID));
        #echo(var_dump($result));
        if (count($result) > 0){
            //make an html table with search results
            //remove old table result
            echo '<table>';
            for ($i = 0; $i < count($result); $i++) {
                $row = $result[$i];
                #echo $row;
                echo "<tr>";
                echo "<td>" . $row->ID . "</td>";
                echo "<td>" . $row->driverFirstName . ' ' . $row->driverLastName . "</td>";
                echo "<td>" . $row->startDateTime . "</td>";
                echo "<td>" . $row->startCity . ', ' . $row->startStateCode . "</td>";
                echo "</tr>";
            }
            echo '</table>';
        }
        else {
            //indicate that no results were returned
            echo "No Results Found";
        }

    }
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Admin Home</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/stylesheet.css">
        <nav class = "adminnav">
            <form action = "new_trip.php" method="post">
                <button type="submit" id= "tripButton" class="tripButton">Create A Trip</button>
            </form>
            <h2>Drive and Doc</h2>
            <a href="../../logout.php">
                <button id= "logoutButton" class="logoutButton">Logout</button>
            </a>
        </nav>
    </head>
    <body>
        <h1>Active Trips</h1>
        <h3><a href="past_trips.php">View Completed Trips</a></h3>
        <div class="searchContainer">
            <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get"> <!-- action = '..\..\api\trips\read.php'  method='get' >--> 
                <input type="text" placeholder="Trip Record" class="search" name="queryStr">
                <button type="submit" class="searchButton">Search</button>
            </form>
        </div>
        <div class="tripsView">
            <h4>List of Active Trips</h4>           
            <table class="tripsTable">
                <tr><!--examples until functionality in place-->
                    <th>Trip ID</th>
                    <th>Driver</th>
                    <th>Start Date</th>
                    <th>Start Location</th>
                </tr>
                <tr>
                    <td><a href = "">0000001</a></td>
                    <td>Joe Bob</td>
                    <td>9/17/2022</td>
                    <td>Topeka, KS</td>
                </tr>
                <tr>
                    <td><a href>0000233</a></td>
                    <td>John Doe</td>
                    <td>9/20/2022</td>
                    <td>Chicago, IL</td>
                </tr>
                <tr>
                    <td><a href>0000999</a></td>
                    <td>Amy Smith</td>
                    <td>9/30/2022</td>
                    <td>Dallas,TX</td>
                </tr>
            </table> 
        </div>
    </body>
    <!---Modal Code for future impl-->
    <!---<div id="tripModal" class="modal">
                        <div class="createTrip">
                            <form form action = "trip_detail.php" method="post" id="newTripForm">
                            <span class="close">&times;</span>
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
                        </div> 
                    </div>
                    <script>
                        // Get the trip modal
                        var modal = document.getElementById("tripModal");
                        // Get the create new trip button to open modal
                        var modalBtn = document.getElementById("tripButton");
                        // Get element to close modal
                        var span = document.getElementById("close")[0];
                        // Function to open the modal on button click
                        modalBtn.onclick = function() {modal.style.display = "block";}
                        // Function to close the modal on 'x' click
                        span.onclick = function() {modal.style.display = "none";}
                        // Function to close the modal if user clicks outside of the modal
                        window.onclick = function() {
                            if(event.target === modal) {
                                modal.style.display = "none";
                            }
                        }
                    </script>-->
</html>