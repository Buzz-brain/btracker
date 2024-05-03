<?php

include("connection.php");

$is_invalid = false;

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $sql = sprintf("SELECT * FROM user
                    WHERE email = '%s'",
                   $mysqli->real_escape_string($_POST["email"]));
    
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
    
    if ($user) {
        
        if (password_verify($_POST["password"], $user["password"])) {
            
            session_start();
            
            session_regenerate_id();
            
            $_SESSION["user_id"] = $user["id"];
            
            header("Location: dashboard.php");
            exit;
        }
    } 

    $is_invalid = true;
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>
    <link rel="stylesheet" href="form.css">
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script defer src="jquery3.6.1.js"></script>
    <script defer src="logIn.js"></script>
</head>
<body>
    <?php if ($is_invalid): ?>
        <div id="loginMessage">&nbsp;Invalid Email or Password</div>
    <?php endif; ?>
        <div id="message"></div>
    <main class="container flex-center">
        <div class="logo">
            <a href="index.php"><img src="logoWhiteBg.png" alt="Logo Image"></a>
        </div>
        <div class="flex">
            <form action="" method="post" name="form">
                <h1>Welcome Back!</h1>
                <div class="inputCtn">
                    <span id="placeholder">Email Address</span>
                    <input type="email" class="input" placeholder="Email Address" name="email">
                </div>
                <div class="inputCtn">
                    <span id="placeholder">Password</span>
                    <input type="password" class="input" placeholder="Password" name="password">
                </div>
                <button type="submit" id="loginBtn">Login</button>
                <p class="haveAccount">Don't have an account? <a href="signup.php">Sign Up</a></p> 
            </form>
            <div class="signImg flex-center">
                <img src="login.png" alt="Login image">
            </div>
        </div>
    </main>
</body>
</html>