<?php

class User {
    //DB connection
    private $conn;
    private $table = 'USER';
    private $param_username;
    private $param_password;
    private $hashed_password;


    //user properties
    public $id;
    public $username;
    public $password;
    public $firstName;
    public $lastName;



    // CONSTRUCTOR
    public function __construct($db) {
        $this->conn = $db;
    }

    public function userExists() {
        $result = false;
        // Prepare a select statement
        $sql = "SELECT ID FROM ". $this->table ." WHERE Username = :username";

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
    
    public function loginIsValid() {
        // Prepare a select statement
        $sql = "SELECT ID, Username, Password FROM ". $this->table ." WHERE Username = :username";
        
        if($stmt = $this->conn->prepare($sql)){
            // Bind variables to the prepared statement as parameters
            $stmt->bindParam(":username", $this->param_username, PDO::PARAM_STR);
            
            // Set parameters
            $this->param_username = $this->username;
            
            // Attempt to execute the prepared statement
            if($stmt->execute()){
                // Check if username exists, if yes then verify password
                if($stmt->rowCount() == 1){
                    if($row = $stmt->fetch()){
                        $this->id = $row["ID"];
                        $this->username = $row["Username"];
                        $this->hashed_password = $row["Password"];
                        if(password_verify($this->password, $this->hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $this->id;
                            $_SESSION["username"] = $this->username;                            
                            
                            // Redirect user to welcome page
                            return true;
                        } else{
                            // Password is not valid, display a generic error message
                           return false;
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    return false;
                }
            } else{
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close statement
            unset($stmt);
        }

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
