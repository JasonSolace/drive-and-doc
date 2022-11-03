<?php
    $loginFailed = $_GET["loginFailed"];
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
            <form action = "login.php" method="post">
                <h1>Login</h1>           
                <?php 
                    if(!empty($loginFailed)) {
                        echo "<p><font color=red>Incorrect Username or Password</p>";
                    }
                ?>
                <br>
                <input type="text" placeholder="Enter Your Username" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" required>
                <br>
                <input type="password" placeholder="Enter Your Password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required>                
                <button type="submit" class="loginBtn">Login</button>
                <button type="submit" class="newAccntBtn" formaction="register.php" formnovalidate>Create a New Account</button>
            </form>
            </div>
    </body>
</html>