<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect them to welcome page
/*if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if(isset($_SESSION["usertype"])) {
        if ($_SESSION["usertype"] === 1) { // user is driver
        header("location: ./views/driver/home.php");
        exit();
        }
        if ($_SESSION["usertype"] === 0) { // user is admin
            header("location: ./views/admin/home.php");
            exit();
        }
    }
}*/

// Include Database config file
require_once "../../../config/Database.php";
include_once "../../../models/User.php";

// Instantiate DB object
$database = new Database();
$db = $database->connect();

// Instantiate User model
$user_obj = new User($db);

// Define variables and initialize with empty values
$username_err = $password_err = $login_err = "";

// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter username.";
    } else {
        $user_obj->username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else {
        $user_obj->password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        if ($user_obj->loginIsValid()) {
            if(isset($_SESSION["usertype"])) {
                if ($_SESSION["usertype"] === 1) { // user is driver
                header("location: ../../../views/driver/home.php");
                exit;
                }
                if ($_SESSION["usertype"] === 0) { // user is admin
                    header("location: ../../../views/admin/home.php");
                    exit;
                }
            }
        } else {
            header("Location: ../../../index.php?loginFailed=true&reason=password");
            exit;
        }
    }
}
?>