<?php


class Document {
    

    //DB Connection
    private $conn;
    private $table = 'document';

    private $bucket = 'drive-and-doc';
    //S3 Connection
    private $s3_conn;

    // constructor
    public function __construct($db, $s3) {
        $this->conn = $db;
        $this->s3_conn = $s3;
    }


    public function upload() {


    }




}




?>