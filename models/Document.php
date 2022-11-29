<?php


class Document {
    

    //DB Connection
    private $conn;
    private $table = 'document';

    //S3 Connection
    private $s3_conn;

    // constructor
    public function __construct($db, $s3) {
        $this->conn = $db;
        $this->s3_conn = $s3;
    }







}




?>