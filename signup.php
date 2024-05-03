<?php

include("connection.php");


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    if (empty($_POST["name"]) || empty($_POST["email"]) || empty($_POST["password"]) || empty($_POST["cPassword"]) ) {
        die("All fields are required");
    }
    if ( ! filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
        die("Valid email is required");
    }
    if (strlen($_POST["name"]) < 5) {
        die("Name must be greater or equal to 5 characters");
    }
    if (strlen($_POST["password"]) !== 4) {
        die("Password must be 4 characters");
    }
    if ($_POST["password"] !== $_POST["cPassword"]) {
        die("Password does not match");
    }

    $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);


    $sql = "INSERT INTO user (name, email, password)
            VALUES (?, ?, ?)";
            
    $stmt = $mysqli->stmt_init();

    if ( ! $stmt->prepare($sql)) {
        die("SQL error: " . $mysqli->error);
    }

    $stmt->bind_param("sss",
                    $_POST["name"],
                    $_POST["email"],
                    $password_hash);
                    
    if ($stmt->execute()) {
        header("Location: login.php");
        exit;
    } else {
        if ($mysqli->errno === 1062) {
            die("email already taken");
        } else {
            die($mysqli->error . " " . $mysqli->errno);
        }
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up page</title>
    <link rel="stylesheet" href="form.css">
    <script defer src="register.js"></script>
</head>
<body>
    <div id="message"></div>
    <main class="container flex-center">
        <div class="logo">
            <a href="index.php"><img src="logoWhiteBg.png" alt="Logo Image"></a>
        </div>
        <div class="flex">
            <form action="" method="post" name="form" novalidate>
                <h1>Welcome !</h1>
                <div class="inputCtn">
                    <span id="placeholder">Name</span>
                    <input type="text" class="input" placeholder="Name" name="name">
                </div>
                <div class="inputCtn">
                    <span id="placeholder">Email Address</span>
                    <input type="email" class="input" placeholder="Email Address" name="email">
                </div>
                <div class="inputCtn">
                    <span id="placeholder">Password</span>
                    <input type="password" class="input" placeholder="Password" name="password">
                </div>
                <div class="inputCtn">
                    <span id="placeholder">Confirm Password</span>
                <input type="password" class="input" placeholder="Confirm Password" name="cPassword">
                </div>
                <button type="submit">Sign Up</button>
                <p class="haveAccount">Already have an Account? <a href="login.php">Login</a></p>
            </form>
            <div class="signImg flex-center">
                <img src="signup.png" alt="Sign up image" width="100px">
            </div>
        </div>
    </main>
</body>
</html>
