<?php


class Document {
    //Doc variables
    public $filename; //passed name of the file
    public $s3Filename; //s3 file has <ID>_ in db prepended to keep S3 filenames unique
    public $uploadedTime; //uploaded time
    public $ID; //id in the database
    public $docTypeId; //document type in db (0=trip log, 1 = receipt, 2 = other)
    public $tripId; //associated trip id

    //DB Connection
    public $conn;
    public $table = 'document';

    public $bucket = 'drive-and-doc';
    //S3 Connection
    public $s3_conn;

    // constructor
    public function __construct($db, $s3) {
        $this->conn = $db;
        $this->s3_conn = $s3;
    }

    public function tripCheck(){
        //checks to see if the user trip exists in the trip table
        //returns boolean

        $query = 'SELECT COUNT(*) "tripIdCount" FROM TRIP WHERE ID = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->tripId, PDO::PARAM_INT);
        if ($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            if ($tripIdCount > 0){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            printf('ERROR: %s.\n', $stmt->error);
            return false;
        }  
    }

    public function docTypeCheck(){
        //checks to see that the passed doc type id exists
        //returns boolean
        $query = 'SELECT COUNT(*) "docTypeCount" FROM DOCUMENT_TYPE WHERE ID = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $this->docTypeId, PDO::PARAM_INT);
        if ($stmt->execute()){
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            extract($row);
            if ($docTypeCount > 0){
                return true;
            }
            else {
                return false;
            }
        }
        else {
            printf('ERROR: %s.\n', $stmt->error);
            return false;
        } 
    }


    public function upload() {
        //creates a record for the document to upload in the database
        //appends that record's primary key to the filename (for uniqueness in S3)
        //loads the document to S3
        

        //create a record in the db for this file
        $query = "INSERT INTO document (
                            DocFilePath,
                            DocTypeId, 
                            TripId,
                            UploadDatetime
                        )
                  VALUES (
                        :docFileName,
                        :docTypeId,
                        :tripId,
                        :uploadedTime
                        );
                        ";
        
        $stmt = $this->conn->prepare($query);

        //clean data to prevent sql injection
        $this->docFileName = htmlspecialchars(strip_tags($this->filename));
        $this->docTypeId = htmlspecialchars(strip_tags($this->docTypeId));
        $this->tripId = htmlspecialchars(strip_tags($this->tripId));
        $this->uploadTime = htmlspecialchars(strip_tags($this->uploadedTime));

        //bind data
        $stmt->bindParam(':docFileName', $this->filename);
        $stmt->bindParam(':docTypeId', $this->docTypeId);
        $stmt->bindParam(':tripId', $this->tripId);
        $stmt->bindParam(':uploadedTime', $this->uploadedTime);

        //execute the insert statement
        if ($stmt->execute()){
            //get the created record
            $newDoc = ' 
                SELECT 
                    d.ID,
                    d.DocFilePath,
                    d.DocTypeId,
                    d.TripId,
                    d.UploadDatetime
                FROM DOCUMENT d
                WHERE d.ID = (SELECT MAX(ID) FROM DOCUMENT)';
            $stmtId = $this->conn->prepare($newDoc);
            if ($stmtId->execute()){
                $row = $stmtId->fetch(PDO::FETCH_ASSOC);
                extract($row);
                $this->id = $ID;
                $this->filename = $DocFilePath;
                $this->s3Filename = strval($ID) . '_' . $DocFilePath;
                $this->docTypeId = $DocTypeId;
                $this->tripId = $TripId;
                $this->uploadedTime = $UploadDatetime;

            } else {
                printf('Error retrieving newly created Document: %s.\n', $stmtId->error);
            }

        }
        else {
            //assume here document db record creation failed
            //print error
            printf('Error: %s.\n', $stmt->error);
        }
        
        //with document record load the doc to S3    
        $bucket = 'drive-and-doc';
        $file_Path = $this->filename;
        $key = $this->s3Filename; //basename($file_Path);
        try {
            $result = $this->s3_conn->putObject([
                'Bucket' => $bucket,
                'Key' => $key,
                'Body' => fopen($file_Path, 'r'),
                //'ACL' => 'public-read',
            ]);
            //if image uploaded to S3 successfully, update the document record to reflect this
            //this will allow the API to exclude unsuccessful uploads from requests to retrieve docs for a trip
            $query = "UPDATE DOCUMENT SET UploadSuccess = 1 WHERE ID = :id";
            $stmt = $this->conn->prepare($query);
            $stmt->bindParam(':id', $this->ID);
            if ($stmt->execute()){
                echo 'Image uploaded successfully. image path is: '. $result->get('ObjectURL');
            }
            else {
                printf('Document uploaded, but there was an error updating document success status: %s.\n', $stmtId->error);
            }
        }
        catch (Exception $e) {
            echo 'Error: ' . $e->getMessage();
        }
    }

    




}




?>