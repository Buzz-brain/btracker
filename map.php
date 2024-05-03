<?php

include("connection.php");

session_start();

if (isset($_SESSION["user_id"])) {
    
    $sql = "SELECT * FROM user
            WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();
}

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Location web tracker</title>
    <link rel="stylesheet" href="style.css">
    <script defer src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script defer src="jquery3.6.1.js"></script>
    <script defer src="dashboard.js"></script>
</head>
<body>
<?php if (isset($user)):  ?>
    <div class="menuOverlay">
        <nav>
            <div class="logoOnOverlay">
                <div class="logo">
                    <p class="letterB">B</p>
                    <div class="logoText">
                        <p>uzz</p>
                        <p><span class="letterT">t</span>racker</p>
                    </div>
                </div>
                <div class="remove"><img src="menuCancel.png" alt="" width="24px"></div>   
            </div>
            <ul>
                <a href="dashboard.php"><li>Dashboard</li></a>
                <a href="locationhistory.php"><li>Location history</li></a>
                <a href="map.php"><li class="activeOverlay">Map</li></a>
                <a href="index.php"><li>Logout</li></a>
            </ul>
        </nav>
    </div>
    <header>
        <div class="container">
            <nav>
                <div class="logo flex">
                    <img src="logo.png" alt="Logo Image">
                </div>
                <ul>
                    <a href="dashboard.php"><li>Dashboard</li></a>
                    <a href="locationhistory.php"><li>Location history</li></a>
                    <a href="map.php" class="active"><li>Map</li></a>
                    <a href="index.php"><li>Logout</li></a>
                </ul>
                <img id="openMenu" src="menu.png" alt="">
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <h2 class="welcome">Map Location</h2>
            <div class="locationCtn">
                <h1 id="locationDiv" style="display: none"></h1>
                <img id="refreshIcon" style="display: none" src="refreshIcon.png" alt="refresh icon">
                <div id="locationMap" class="locationMapFullView">Getting Map Location...</div>
            </div>
        </div>
    </main>
<?php else:  header("Location: index.php"); endif;
?>
</body>
</html>