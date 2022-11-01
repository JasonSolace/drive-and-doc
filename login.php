<?php
// Initialize the session
session_start();

// Check if the user is already logged in, if yes then redirect them to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
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
}

// Include Database config file
require_once "./config/Database.php";
include_once "./models/User.php";

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
    } else{
        $user_obj->username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter your password.";
    } else{
        $user_obj->password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        if ($user_obj->loginIsValid()) {
            header("location: index.php");
        } else {
            $login_err = "Invalid username or password.";
        }
    }
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
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div>
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div>
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div>
                <input type="submit" class="loginBtn" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
        </form>
    </div>
</body>
</html>