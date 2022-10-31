<?php 
class Database {
    // DB params
    private $url;
    private $dbparts;
    
    private $host;
    private $username;
    private $password;
    private $db_name;

    private $conn;

    public function __construct(){
        /*for prod
        $this->password = getenv('JAWSDB_PW', false);
        $this->host = getenv('JAWSDB_HOST', false);
        $this->username = getenv('JAWSDB_USER', false);
        $this->db_name = getenv('JAWSDB_DB', false);
        /*
        /* for local */
        $this->host = 'au77784bkjx6ipju.cbetxkdyhwsb.us-east-1.rds.amazonaws.com';
        $this->db_name = 'i2fe3t4570qg3cim';
        $this->username = 'in8ma2pxo6kvogvs';
        $this->password = 'wq7s88aa83bpegm1';        
    }

    // DB connect
    public function connect() {


        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
                $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);//use to pass null values in SQL
        }
        catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }



}




?>