<?php

class User {
    //DB connection
    private $conn;
    private $table = 'USER';
    private $param_username;
    private $param_password;

    //user properties
    public $id;
    public $username;
    public $firstName;
    public $lastName;



    // CONSTRUCTOR
    public function __construct($db) {
        $this->conn = $db;
    }

    public function userExists() {
        $result = false;
        // Prepare a select statement
        $sql = "SELECT id FROM ". $this->table ." WHERE username = :username";

        if($stmt = $this->conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $this->param_username, PDO::PARAM_STR);
            
            // Set parameters
            $this->param_username = $this->username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $result =  true;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
        return $result;
    }


    public function create(){ 
        // Prepare an insert statement
        $sql = "INSERT INTO ". $this->table ." (Username, Password, UserTypeId) VALUES (:username, :password, 1)";
         
        if($stmt = $this->conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $this->param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $this->param_password, PDO::PARAM_STR);
            
            // Set parameters
            $this->param_username = $this->username;
            $this->param_password = password_hash($this->password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }
    }



}
