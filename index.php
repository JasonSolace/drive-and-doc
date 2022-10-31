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
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="./css/loginStylesheet.css">
    </head>
    <body>
        <div class="container">
            <form action = "views/admin/home.php" method="post">
                <h1>Login</h1>                
                <br>
                <input type="text" placeholder="Enter Your Username" name="username" required>
                <br>
                <input type="text" placeholder="Enter Your Password" name="password" required>
                <br>
                <a href="" checked="checked">Forgot Password?</a>
                <br>
                <button type="submit" class="loginBtn">Login</button>
            </form>
            </div>
    </body>
</html>