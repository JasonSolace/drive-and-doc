<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title>Drive and Doc Login</title>
        <meta name="description" content="">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="../css/loginStylesheet.css">
    </head>
    <body>
        <div class="container">
            <form action = "../register.php" method="post">
                <h1>Create A New Account</h1>   
                <?php 
                    if(isset($_GET['userFail'])) {
                        echo "<p><font color=red>Usernames Can Only Contain Letters, Numbers, or Underscores</p>";
                    }
                    if(isset($_GET['existing'])) {
                        echo "<p><font color=red>That Username is Already Taken</p>";
                    }
                    if(isset($_GET['passReq'])) {
                        echo "<p><font color=red>Passwords Must Have At Least 6 Characters</p>";
                    }
                    if(isset($_GET['unmatchedPass'])){
                        echo "<p><font color=red>The Passwords Entered Do Not Match</p>";
                    }
                ?>        
                <br>
                <input type="text" placeholder="Enter Your Username" name="username" label="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" required>
                <br>
                <input type="password" placeholder="Enter Your Password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" required> 
                <input type="password" placeholder="Confirm Your Password" name="confirmPass" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" required>                  
                <button type="submit" class="loginBtn">Create a New Account</button>
                <button type="submit" class="newAccntBtn" formaction="../index.php" formnovalidate>Return to Login</button>
            </form>
            </div>
    </body>
</html>