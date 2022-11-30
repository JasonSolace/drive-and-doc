<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: POST');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Authorization,X-Requested-With');
    
    include_once '../../../config/Database.php';
    include_once '../../../config/S3Bucket.php';
    include_once '../../../models/Document.php';  

    $database = new Database();
    $db = $database->connect();
    
    $s3bucket = new S3Bucket();
    $s3 = $s3bucket->connect();

    $document = new Document($db, $s3);

    if (isset($_FILES['image']) && $_FILES['image']['error']==0){
        $allowed = array('jpg' => 'image/jpg',
                         'jpeg' => 'image/jpeg',
                         'giv' => 'image/gif',
                         'png' => 'image/png');
        $filename = $_FILES['image']['name'];
        $filetype = $_FILES['image']['type'];

        print_r('testing');

        //check if invalid file format sent
        $ext = pathinfo($filename, PATHINFO_EXTENSION);
        if(!array_key_exists($ext, $allowed)){
            print_r(json_encode(array('message' => 'Incorrect file format, document must be png/jpg/jpeg/gif')));
            die();//exit
        }

        if(move_uploaded_file($_FILES['image']['tmp_name'], $filename)){
            $bucket = 'drive-and-doc';
            $file_Path = 'Dnd company user.png';
            $key = 'Dnd company user.png'; //basename($file_Path);
            try {
                $result = $s3->putObject([
                    'Bucket' => $bucket,
                    'Key' => $key,
                    'Body' => fopen($file_Path, 'r'),
                    'ACL' => 'public-read',
                ]);
                echo 'Image uploaded successfully. image path is: '. $result->get('ObjectURL');
            }
            catch (Exception $e) {
                echo 'Error: ' . $e->getMessage();
            }
        }
        


    }

    //https://docs.aws.amazon.com/aws-sdk-php/v2/api/class-Aws.S3.S3Client.html#_putObject 
    //https://www.tutsmake.com/upload-file-to-aws-s3-bucket-in-php/
    //https://medium.com/@kentaguilar/simplest-way-to-upload-a-file-to-aws-s3-via-php-e83a9f54ba77
?>