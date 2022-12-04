<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Doc Upload Test</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/loginStylesheet.css">
    </head>
    <body>
        <div class="container">
            <form action = "../controllers/api/documents/index.php" method="post" enctype="multipart/form-data">
                <input type="file" name="image" required>
                <input type="number" placeholder="tripId" name="tripId" required> 
                <input type="number" placeholder="docTypeId" name="docTypeId" required> 
                <button type="submit" class="docUpload">Upload Doc</button>
            </form>
            </div>
    </body>
</html>