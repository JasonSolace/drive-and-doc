<?php
    if(isset($_POST["loginBtn"])) {
        header("Location: views/admin/home.php");
        exit();
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