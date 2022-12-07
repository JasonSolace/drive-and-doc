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
        <div class="container">
            <form action = "../../controllers/api/documents/index.php" method="post" enctype="multipart/form-data">
            <h1>Upload New Document</h1>
            <div class = adminDocUpload>
                <label for="tripID">Document Image: </label>
                <input type="file" name="image" required>
                <br>
                <label for="tripID">Trip ID: </label>
                <input type="number" placeholder="tripId" name="tripId" value=18 readonly>
                <br>
                <label for="docTypeId">Document Type:</label>
                    <input list="documentTypes" id="docTypeId" name="docTypeId">
                    <datalist id="documentTypes">
                        <option value=1>Trip Log
                        <option value=2>Receipt
                        <option value=3>Other
                    </datalist>

                <br>
                <br>
                <button type="submit" class="uploadButton">Upload Doc</button>
                </form>
                <button type="submit" class="cancelButton" formaction="trip_detail.php?tripID=<?php echo $queryString?>" formnovalidate>Cancel</button>
            </div>
        </div>
    </body>
</html>