<?php
    //headers
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    header('Access-Control-Allow-Methods: GET');
    header('Access-Control-Allow-Headers: Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Origin,Authorization,X-Requested-With');
    
    include_once '../../../config/Database.php';
    include_once '../../../config/S3Bucket.php';
    include_once '../../../models/Document.php';  

    $database = new Database();
    $db = $database->connect();

    $s3bucket = new S3Bucket();
    $s3 = $s3bucket->connect();

    $document = new Document($db, $s3);

    $key = 'Dnd company user old.png';
    $bucket = 'drive-and-doc';

    try {
  /*$downloadUrl = $s3->getObjectUrl($bucket,
                                    $key,
                                    '+15 minutes',
                                    array(
                                        'ResponseContentDisposition' => "attachment; filename={$key},'Content-Type' => 'application/octet-stream'",
                                    ));
    print_r($downloadUrl);
*/
    //Creating a presigned URL
        $cmd = $s3->getCommand('GetObject', [
            'Bucket' => 'drive-and-doc',
            'Key' => $key
        ]);

        $request = $s3->createPresignedRequest($cmd, '+20 minutes');

        // Get the actual presigned-url
        $presignedUrl = (string)$request->getUri();
        print_r($presignedUrl);
        /*
        $result = $s3->getObject([
            'Bucket' => $bucket,
            'Key' => $key,
            'ResponseContentDisposition' => 'attachment; filename="Dnd company user.png"',
        ]);
        
$cmd = $s3->getCommand('GetObject', [
    'Bucket' => $bucket,
    'Key' => $key,
    'ResponseContentDisposition' => 'attachment; filename="Dnd company user.png"',
]);
$signed_url = $s3->createPresignedRequest($cmd, '+15 minutes')
                    ->getUri()
                    ->__toString();
            header("Location: {$signed_url}");
*/
//download('Dnd company user.png', 'Test API download.png');
    
/*
        $promise = $s3->getObjectAsync([
            'Bucket' => $bucket,
            'Key' => $key
        ]);
*/

        //$result['Body']->getContents();
        //$test = (string) $result['Body'];
        //var_dump($test);
        //file_put_contents('./test.png', $result['Body']->getContents());
        //$body = $result['Body']->getContents();
        //$body->rewind();
        //$body = $result['Body'];
        //var_dump($body);
        //$body->rewind();
        //$content = $body->read($result['ContentLength']);
        //echo 'Image retrieved successfully:\n';
        
        //readfile($result['Body']);

    }
    catch (Exception $e) {
        echo 'Error: ' . $e->getMessage();
    }

?>