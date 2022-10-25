<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Admin Past Trips</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/stylesheet.css">
        <nav class = "topnav">
            <h2>Drive and Doc</h2>
            <a href="new_trip.html"><button class="tripButton">Create A Trip</button></a>
        </nav>
    </head>
    <body>
        <h1>Completed Trips</h1>
        <h3><a href="index.html">View Active Trips</a></h3>
        <div class="searchContainer">
            <form>
                <input type="text" placeholder="Trip Record" class="search">
                <button type="submit" class="searchButton">Search</button>
            </form>
        </div>
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
                    <td>Joe Bob</td>
                    <td>2/17/2022</td>
                    <td>Boise, ID</td>
                </tr>
                <tr>
                    <td><a href>0000300</a></td>
                    <td>John Doe</td>
                    <td>1/20/2022</td>
                    <td>Montgomery, AL</td>
                </tr>
                <tr>
                    <td><a href>0001999</a></td>
                    <td>Amy Smith</td>
                    <td>3/30/2022</td>
                    <td>Boulder, CO</td>
                </tr>
            </table> 
        </div>
    </body>
</html>