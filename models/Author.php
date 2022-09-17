<?php 
class Author {
    // DB stuff
    private $conn;
    private $table = 'authors';

    // AUTHOR PROPERTIES
    public $id;
    public $author;

    // CONSTRUCTOR
    public function __construct($db) {
        $this->conn = $db;
    }

    // GET AUTHORS
    public function read() {
        // create query
        $query = 'SELECT id, author FROM ' . $this->table;
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

        // GET SINGLE AUTHOR
        public function read_single() {
            // create query
            $query = 'SELECT id, author FROM ' . $this->table . ' WHERE id = ?';
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // bind params
            $stmt->bindParam(1,$this->id);
            // execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->author = $row['author'];
        }

        // CREATE AUTHOR
        public function create() {
            // create query
            $query = 'INSERT INTO ' . $this->table . ' (author) VALUES (:author)';
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // clean data
            $this->author = htmlspecialchars(strip_tags($this->author));

            // bind params
            $stmt->bindParam(':author',$this->author);

            // execute query
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

            // UPDATE AUTHOR
            public function update() {
            // create query
            $query = 'UPDATE ' . $this->table . ' SET author=:author WHERE id = :id';
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->author = htmlspecialchars(strip_tags($this->author));

            // bind params
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':author',$this->author);

            // execute query
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

            // DELETE AUTHOR
            public function delete() {
            // create query
            $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // clean data
            $this->id = htmlspecialchars(strip_tags($this->id));

            // bind params
            $stmt->bindParam(':id',$this->id);

            // execute query
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

}
