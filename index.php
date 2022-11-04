<?php
// Check if the user is already logged in, if yes then redirect them to home page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    if(isset($_SESSION["usertype"])) {
        if ($_SESSION["usertype"] === 1) { // user is driver
        header("location: ./views/driver/home.php");
        exit;
        }
        if ($_SESSION["usertype"] === 0) { // user is admin
            header("location: ./views/admin/home.php");
            exit;
        }
    }
} else {
    header("location: ./login.php");
    exit;
}
?>