<?php

include("connection.php");

session_start();

if (isset($_SESSION["user_id"])) {

    $sql = "SELECT * FROM user WHERE id = {$_SESSION["user_id"]}";
            
    $result = $mysqli->query($sql);
    
    $user = $result->fetch_assoc();

    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Get location name from the form
        $locationName=$_POST['locationName'];
        $mapLocation=$_POST['mapLocation'];


        // Check the previous location for this user
        $check_query = "SELECT * FROM locationhistory WHERE user_id = {$_SESSION["user_id"]} ORDER BY id DESC LIMIT 1";
        $check_result = mysqli_query($mysqli, $check_query);

        if (mysqli_num_rows($check_result) > 0) {
            // Previous location exists
            $row = mysqli_fetch_assoc($check_result);
            $prev_location = $row['location'];
    
            // Check if the new location is different from the previous one
            if ($locationName != $prev_location) {
                // Insert new location into the database
                $myinsertquery="INSERT INTO `locationhistory` (`user_id`, `location`, `map`)
                VALUES ({$_SESSION["user_id"]}, '$locationName', '$mapLocation')";
                mysqli_select_db($mysqli, "if0_36268011_webtracker");
                mysqli_query($mysqli, $myinsertquery);
                if (mysqli_query($mysqli, $insert_query)) {
                    // Inserted successfully
                    $response = array('success' => true, 'message' => 'New location added successfully.');
                    echo json_encode($response);
                } else {
                    // Error inserting record
                    $response = array('success' => false, 'message' => 'Error adding new location.');
                    echo json_encode($response);
                }
            } else {
                // New location is the same as previous location
                $response = array('success' => false, 'message' => 'Location has not changed.');
                echo json_encode($response);
            }
        } else {
            // No previous location, insert the first location
            $myinsertquery="INSERT INTO `locationhistory` (`user_id`, `location`, `map`)
            VALUES ({$_SESSION["user_id"]}, '$locationName', '$mapLocation')";
            mysqli_select_db($mysqli, "if0_36268011_webtracker");
            mysqli_query($mysqli, $myinsertquery);
            if (mysqli_query($mysqli, $insert_query)) {
                // Inserted successfully
                $response = array('success' => true, 'message' => 'First location added successfully.');
                echo json_encode($response);
            } else {
                // Error inserting record
                $response = array('success' => false, 'message' => 'Error adding first location.');
                echo json_encode($response);
            }
        }
    } 
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
                <a href="dashboard.php"><li class="activeOverlay">Dashboard</li></a>
                <a href="locationhistory.php"><li>Location history</li></a>
                <a href="map.php"><li>Map</li></a>
                <a href="logout.php"><li>Logout</li></a>
            </ul>
        </nav>
    </div>
    <header>
        <div class="container">
            <nav>
                <div class="logo">
                    <img src="logo.png" alt="Logo Image">
                </div>
                <ul>
                    <a href="dashboard.php"><li class="active">Dashboard</li></a>
                    <a href="locationhistory.php"><li>Location history</li></a>
                    <a href="map.php"><li>Map</li></a>
                    <a href="logout.php"><li>Logout</li></a>
                </ul>
                <img id="openMenu" src="menu.png" alt="">
            </nav>
        </div>
    </header>
    <main>
        <div class="container">
            <h2 class="welcome">Welcome, <?= htmlspecialchars($user["name"]) ?></h2> 

            <div class="locationCtn">
                <div class="locationText">
                    <img id="refreshIcon" src="refreshIcon.png" alt="refresh icon">
                    <p>Current Location</p>
                    <h1 id="locationDiv">Getting Location..</h1>
                </div>
                <div id="locationMap" class="locationMap" name="mapLocation">Getting Map Location..</div>
            </div>
        </div>
    </main>
</body>
<?php else:  header("Location: login.php"); endif;?>
</html>