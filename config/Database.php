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

    // DB connect
    public function connect() {
        $this->url = getenv('JAWSDB_URL');
        $this->dbparts = parse_url($this->url);
    
        $this->host = $this->dbparts['host'];
        $this->username = $this->dbparts['user'];
        $this->password = $this->dbparts['pass'];
        $this->db_name = ltrim($this->dbparts['path'],'/');

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