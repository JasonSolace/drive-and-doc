<?php 
class Quote {
    // DB stuff
    private $conn;
    private $table = 'quotes';

    // QUOTE PROPERTIES
    public $id;
    public $quote;
    public $authorId;
    public $author;
    public $categoryId;
    public $category;


    // CONSTRUCTOR
    public function __construct($db) {
        $this->conn = $db;
    }

    // GET QUOTES
    public function read() {
        // create query
        $query = 'SELECT q.id, q.quote, q.authorId, a.author, q.categoryId, c.category FROM '
         . $this->table . ' q ' 
         . 'JOIN authors a ON q.authorId = a.id '
         . 'JOIN categories c ON q.categoryId = c.id ';
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    public function read_with_author() {
        // create query
        $query = 'SELECT q.id, q.quote, q.authorId, a.author, q.categoryId, c.category FROM '
         . $this->table . ' q ' 
         . 'JOIN authors a ON q.authorId = a.id '
         . 'JOIN categories c ON q.categoryId = c.id '
         . 'WHERE q.authorId = :authorId';
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // bind params
        $stmt->bindParam(':authorId',$this->authorId);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    public function read_with_category() {
        // create query
        $query = 'SELECT q.id, q.quote, q.authorId, a.author, q.categoryId, c.category FROM '
         . $this->table . ' q ' 
         . 'JOIN authors a ON q.authorId = a.id '
         . 'JOIN categories c ON q.categoryId = c.id '
         . 'WHERE q.categoryId = :categoryId';

        // prepare statement
        $stmt = $this->conn->prepare($query);
        // bind params
        $stmt->bindParam(':categoryId',$this->categoryId);
        // execute query
        $stmt->execute();
        return $stmt;
    }
    public function read_with_author_and_category() {
        // create query
        $query = 'SELECT q.id, q.quote, q.authorId, a.author, q.categoryId, c.category FROM '
         . $this->table . ' q ' 
         . 'JOIN authors a ON q.authorId = a.id '
         . 'JOIN categories c ON q.categoryId = c.id '
         . 'WHERE q.categoryId = :categoryId AND q.authorId = :authorId';
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // bind params
        $stmt->bindParam(':authorId',$this->authorId);
        $stmt->bindParam(':categoryId',$this->categoryId);

        // execute query
        $stmt->execute();
        return $stmt;
    }

    // GET SINGLE QUOTE
    public function read_single() {
        // create query
        $query = 'SELECT q.id, q.quote, q.authorId, a.author, q.categoryId, c.category FROM '
        . $this->table . ' q ' 
        . 'JOIN authors a ON q.authorId = a.id '
        . 'JOIN categories c ON q.categoryId = c.id '
        . 'WHERE q.id = ?';
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // bind params
        $stmt->bindParam(1,$this->id);
        // execute query
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        $this->quote = $row['quote'];
        $this->authorId = $row['authorId'];
        $this->author = $row['author'];
        $this->categoryId = $row['categoryId'];
        $this->category = $row['category'];
    }

    // CREATE QUOTE
    public function create() {
        // create query
        $query = 'INSERT INTO ' . $this->table . ' (quote, authorId, categoryId) VALUES (:quote, :authorId, :categoryId)';
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // clean data
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        // bind params
        $stmt->bindParam(':quote',$this->quote);
        $stmt->bindParam(':authorId',$this->authorId);
        $stmt->bindParam(':categoryId',$this->categoryId);

        // execute query
        if ($stmt->execute()) {
            $this->id = $this->conn->lastInsertId();
            return true;
        } 
        //printf("Error: %s.\n", $stmt->error);
        return false;
    }

        // UPDATE QUOTE
        public function update() {
        // create query
        $query = 'UPDATE ' . $this->table . ' SET quote=:quote, authorId=:authorId, categoryId=:categoryId WHERE id = :id';
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // clean data
        $this->id = htmlspecialchars(strip_tags($this->id));
        $this->quote = htmlspecialchars(strip_tags($this->quote));
        $this->authorId = htmlspecialchars(strip_tags($this->authorId));
        $this->categoryId = htmlspecialchars(strip_tags($this->categoryId));

        // bind params
        $stmt->bindParam(':id',$this->id);
        $stmt->bindParam(':quote',$this->quote);
        $stmt->bindParam(':authorId',$this->authorId);
        $stmt->bindParam(':categoryId',$this->categoryId);

        // execute query
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } 
        //printf("Error: %s.\n", $stmt->error);
        return false;
    }

        // DELETE QUOTE
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
    // VALIDATE Author
    public function authorIsValid() {
        // create query
        $query = 'SELECT id, author FROM authors WHERE id = ?';
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // bind params
        $stmt->bindParam(1,$this->authorId);
        // execute query
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } 
        return false;
    }
    // VALIDATE Category
    public function categoryIsValid() {
        // create query
        $query = 'SELECT id, category FROM categories WHERE id = ?';
        // prepare statement
        $stmt = $this->conn->prepare($query);
        // bind params
        $stmt->bindParam(1,$this->categoryId);
        // execute query
        $stmt->execute();
        if ($stmt->rowCount() > 0) {
            return true;
        } 
        return false;
    }

        // VALIDATE Category
        public function quoteIsValid() {
            // create query
            $query = 'SELECT id, quote FROM ' . $this->table . ' WHERE id = ?';
            // prepare statement
            $stmt = $this->conn->prepare($query);
            // bind params
            $stmt->bindParam(1,$this->id);
            // execute query
            $stmt->execute();
            if ($stmt->rowCount() > 0) {
                return true;
            } 
            return false;
        }

}
