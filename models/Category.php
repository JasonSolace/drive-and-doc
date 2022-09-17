<?php 
class Category {
    // DB stuff
    private $conn;
    private $table = 'categories';

    // CATEGORY PROPERTIES
    public $id;
    public $category;

    // CONSTRUCTOR
    public function __construct($db) {
        $this->conn = $db;
    }

    // GET CATEGORIES
    public function read() {
        // create query
        $query = 'SELECT id, category FROM ' . $this->table;
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }

        // GET SINGLE CATEGORY
        public function read_single() {
            // create query
            $query = 'SELECT id, category FROM ' . $this->table . ' WHERE id = ?';
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // bind params
            $stmt->bindParam(1,$this->id);
            // execute query
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $this->category = $row['category'];
        }

        // CREATE CATEGORY
        public function create() {
            // create query
            $query = 'INSERT INTO ' . $this->table . ' (category) VALUES (:category)';
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // clean data
            $this->category = htmlspecialchars(strip_tags($this->category));

            // bind params
            $stmt->bindParam(':category',$this->category);

            // execute query
            if ($stmt->execute()) {
                $this->id = $this->conn->lastInsertId();
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

            // UPDATE CATEGORY
            public function update() {
            // create query
            $query = 'UPDATE ' . $this->table . ' SET category=:category WHERE id = :id';
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // clean data
            $this->id = htmlspecialchars(strip_tags($this->id));
            $this->category = htmlspecialchars(strip_tags($this->category));

            // bind params
            $stmt->bindParam(':id',$this->id);
            $stmt->bindParam(':category',$this->category);

            // execute query
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } 
            //printf("Error: %s.\n", $stmt->error);
            return false;
        }

            // DELETE CATEGORY
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
