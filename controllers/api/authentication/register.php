<?php
// Include database connection file

// IMPORTS
require_once "../../../config/Database.php";
include_once "../../../models/User.php";

// Instantiate DB object
$database = new Database();
$db = $database->connect();

// Instantiate User model
$user_obj = new User($db);


// Define variables and initialize with empty values
//$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Username can only contain letters, numbers, and underscores.";
        header("Location: ../../../views/newAccount.php?userFail=true&reason=username");
        exit;
    } else{
        $user_obj->username = trim($_POST["username"]);
        if ($user_obj->userExists()) {
            $username_err = "This username is already taken.";
            header("Location: ../../../views/newAccount.php?existing=true&reason=username");
            exit;
        }
    }
    
    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password must have atleast 6 characters.";
        header("Location: ../../../views/newAccount.php?passReq=true&reason=password");
        exit;
    } else{
        $user_obj->password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirmPass"]))){
        $confirm_password_err = "Please confirm password.";     
    } else{
        $confirm_password = trim($_POST["confirmPass"]);
        if(empty($password_err) && ($user_obj->password  != $confirm_password)){
            $confirm_password_err = "Password did not match.";
            header("Location: ../../../views/newAccount.php?unmatchedPass=true&reason=password");
            exit;
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        $user_obj->create();
        header("Location: ../../../index.php");
        exit;
    }
    
    // Close connection
    unset($pdo);
}
?>