<!DOCTYPE html>
<!--[if lt IE 7]>      <html class="no-js lt-ie9 lt-ie8 lt-ie7"> <![endif]-->
<!--[if IE 7]>         <html class="no-js lt-ie9 lt-ie8"> <![endif]-->
<!--[if IE 8]>         <html class="no-js lt-ie9"> <![endif]-->
<!--[if gt IE 8]>      <html class="no-js"> <!--<![endif]-->
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Driver Trip Detail</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/stylesheet.css">
    </head>
    <body>
        <!--[if lt IE 7]>
            <p class="browsehappy">You are using an <strong>outdated</strong> browser. Please <a href="#">upgrade your browser</a> to improve your experience.</p>
        <![endif]-->
        <main>
            <h1>Drive and Doc</h1>
            <nav class="pageHeader">
                <button>View Current Trips</button>
                <button>View Past Trips</button>
            </nav>
            <h2>Driver Trip Details</h2>
            <div class="tripDetail">
                
                <h3 class="tripDetailHeader">Trip Details</h3>
                <div class="tripDetailDriver">Driver: Driver A</div>
                <div class="tripDetailUID">User ID: 01234</div>                
                <div class="tripDetailStartTime">Start Date: 9-17-2022</div>
                <div class="tripDetailArrivalTime">Expected Arrival: 9-18-2022</div>
                <div class="tripDetailStartLoc">Start Location: Topeka, KS</div>
                <div class="tripDetailDest">Destination: Wichita, KS</div>
            </div>

            <div class="tripDocs">
                <div class="docHistHeader">
                    <h3>Document History</h3>
                    <button>Add New</button>
                </div>
                <table class="docTable">
                    <tr>
                        <th>Upload Date</th>
                        <th>Document Type</th>
                        <th>Download</th>
                    </tr>
                    <tr>
                        <td>9-17-2022 10:00 AM</td>
                        <td>Load Permit</td>
                        <td>
                            <button type="submit" class="docDownload">Download</button>
                        </td>
                    </tr> 
                    <tr>
                        <td>9-18-2022 8:00 AM</td>
                        <td>Trip Log</td>
                        <td>
                            <button type="submit" class="docDownload">Download</button>
                        </td>
                    </tr>

                </table>
            </div>


        

    </body>
</html>