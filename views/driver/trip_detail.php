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
        </nav>
    </head>
    <body>
        <h1>Trip Record Details</h1>
        <h3><a href="index.html">View Active Trips</a> | <a href="past_trips.html">View Completed Trips</a></h3>
            <div class="tripDetail">                
                <div class="tripDetailID"><strong>Trip ID</strong><br>0000001</div>  
                <div class="tripDetailDriver"><strong>Driver</strong><br>Joe Bob</div> 
                <div class="tripDetailArrivalTime"><strong>Expected Arrival</strong><br>9-18-2022</div>             
                <div class="tripDetailStartTime"><strong>Start Date</strong><br>9-17-2022</div>
                <div class="tripDetailStartLoc"><strong>Start Location</strong><br>Topeka, KS</div>
                <div class="tripDetailDest"><strong>Destination</strong><br>Fort Hays, KS</div>
            </div>
            <br>
                <div class="docHistHeaderDriver">
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