<?php
    // Check if the user is already logged in, if yes then redirect them to home page
    if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
        if(isset($_SESSION["usertype"])) {
            if ($_SESSION["usertype"] === 1) { // user is driver
            header("location: ./views/driver/home.php");
            exit();
            }
        }
    } else {
        header("location: ./login.php");
        exit;
    }

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
        <title>Drive and Doc Admin Home</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/stylesheet.css">
        <nav class = "topnav">
            <h2>Drive and Doc</h2>
            <form action = "new_trip.php" method="post">
                <button type="submit" class="tripButton">Create A Trip</button>
            </form>
        </nav>
    </head>
    <body>
        <h1>Active Trips</h1>
        <h3><a href="past_trips.php">View Completed Trips</a></h3>
        <div class="searchContainer">
            <form>
                <input type="text" placeholder="Trip Record" class="search">
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
</html>