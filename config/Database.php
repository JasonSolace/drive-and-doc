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
        */
        $this->host = 'localhost';
        $this->db_name = 'drive_and_doc';
        $this->username = 'root';
        $this->password = '';

    }

    // DB connect
    public function connect() {


        $this->conn = null;
        try {
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name,
            $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }
        return $this->conn;
    }



}




?>