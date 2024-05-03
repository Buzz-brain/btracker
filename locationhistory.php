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
    <script defer src="locationHistory.js"></script>
</head>
<body style="padding-bottom: 50px;">
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
                <a href="locationhistory.php"><li class="activeOverlay">Location history</li></a>
                <a href="map.php"><li>Map</li></a>
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
                    <a href="locationhistory.php" class="active"><li>Location history</li></a>
                    <a href="map.php"><li>Map</li></a>
                    <a href="index.php"><li>Logout</li></a>
                </ul>
                <img id="openMenu" src="menu.png" alt="">
            </nav>
        </div>
    </header>
    <main class="lmain">
        <div class="container">
            <h2 class="welcome">Location History</h2>
        </div>
            <table class="container">
                <tr class="flex">
                    <th class="date">Date</th>
                    <th class="time">Time</th>
                    <th class="locationDiv">Location</th>
                </tr>
            <?php 
            include("connection.php");
            $sql = "SELECT * FROM locationhistory WHERE user_id = {$_SESSION["user_id"]}";
                // SQL query to get all users
                $result = $mysqli->query($sql);
                // Check if there are results
                if ($result->num_rows > 0) :
                    // Output data of each row
                    while ($row = $result->fetch_assoc()): ?>
                    <!-- Display if user location history is added-->
                    <tr>
                        <td><?php echo $row["date"] ?></td>
                        <td><?php echo $row["time"] ?></td>
                        <td class="locationDiv"><?php echo $row["location"] ?> &nbsp; 
                        <div class="viewBtn">
                            <button><img id="viewCancelIcon" src="viewCancel.png" alt="view location"> </button>
                            <button id="viewIconBtn"><img  src="view.png" alt="view location"></button>
                        </div>
                    </tr> 
                    <tr id="viewMap">
                        <td colspan="3"><iframe style="width: 100%; height: 300px" src="<?php echo $row["map"] ?>" frameborder="0"></iframe></td>
                    </tr> 
                    <?php endwhile; else: ?>
                    <!-- Display if no history available -->
                    <tr>
                        <td colspan="3">No history available</td>
                    </tr> 
                    <?php endif;?>
            </table>
    </main>
<?php else:  header("Location: index.php")?>
<?php endif;?>
</body>
</html>