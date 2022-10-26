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
        $this->password = getenv('JAWSDB_PW', false);
        $this->host = getenv('JAWSDB_HOST', false);
        $this->username = getenv('JAWSDB_USER', false);
        $this->db_name = getenv('JAWSDB_DB', false);
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