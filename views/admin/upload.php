<?php 
 $queryString = $_GET['tripID'];
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Doc Upload</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../../css/stylesheet.css">
        <nav class = "topnav">
            <h2>Drive and Doc</h2>
        </nav>
    </head>
    <body>
        <form action = "../../controllers/api/documents/index.php" method="post" enctype="multipart/form-data">
        <h1>Upload New Document</h1>
        <div class = adminDocUpload>
            <label for="tripID">Document Image: </label>
            <input type="file" name="image" required>
            <br>
            <label for="tripID">Trip ID: </label>
            <input type="number" placeholder="tripId" name="tripId" value=<?php echo $queryString ?> readonly>
            <br>
            <label for="docTypeId">Document Type:</label>
            <!---<input list="documentTypes" id="docTypeId" name="docTypeId">-->
                <select list="documentTypes" id="docTypeId" name="docTypeId">
                    <option value=1>Trip Log</option>
                    <option value=2>Receipt</option>
                    <option value=3>Other</option>
                </select>
            <br><br>
            <button type="submit" class="cancelButton" formaction="trip_detail.php?tripID=<?php echo $queryString?>" formnovalidate>Cancel</button>
            <button type="submit" class="uploadButton">Upload Doc</button>
        </div>
        </form>
    </body>
</html>
