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
                <input type="file" name="image" required>
                <br>
                <input type="number" placeholder="tripId" name="tripId" required> Trip ID
                <br>
                <input type="number" placeholder="docTypeId" name="docTypeId" required> Doc Type ID
                <br>
                <br>
                <button type="submit" class="uploadButton">Upload Doc</button>
                <button type="submit" class="cancelButton" formaction="trip_detail.php?tripID=<?php echo $queryString?>" formnovalidate>Cancel</button>
            </div>
            </form>
        </div>
    </body>
</html>