<?php
    // Check if the user is not logged in and redirect to the login page
    if(!isset($_SESSION["loggedin"]) || !$_SESSION["loggedin"] === true){
        header("location: ../../login.php");
        exit;
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
            <form action = "../../index.php" method="post">
                <button type="submit" id= "logoutButton" class="logoutButton">Logout</button>
            </form>
        </nav>
    </head>
    <body>
        <h1>Completed Trips</h1>
        <h3><a href="home.php">View Active Trips</a></h3>
        <div class="tripsView">
            <h4>List of Completed Trips</h4>           
            <table class="tripsTable">
                <tr><!--examples until functionality in place-->
                    <th>Trip ID</th>
                    <th>Driver</th>
                    <th>Start Date</th>
                    <th>Start Location</th>
                </tr>
                <tr>
                    <td><a href = "">0000100</a></td>
                    <td>2/17/2022</td>
                    <td>Boise, ID</td>
                    <td>Portland, OR</td>
                </tr>
                <tr>
                    <td><a href>0000300</a></td>
                    <td>1/20/2022</td>
                    <td>Montgomery, AL</td>
                    <td>Mobile, AL</td>
                </tr>
                <tr>
                    <td><a href>0001999</a></td>
                    <td>3/30/2022</td>
                    <td>Boulder, CO</td>
                    <td>Denver, CO</td>
                </tr>
            </table> 
        </div>
    </body>
</html>