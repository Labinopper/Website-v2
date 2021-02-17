<?php
    require 'db_connection.php';
    include("auth_session.php");

    session_start();
    // When form submitted, check and create user session.
    require 'db_connection.php';
    $gameexists = "";
    if (isset($_POST['Games']) && isset($_POST['date']) && isset($_POST['time'])) {
        $gameid = stripslashes($_REQUEST['Games']);    // removes backslashes
        $gameid = mysqli_real_escape_string($conn, $gameid);
        $date = stripslashes($_REQUEST['date']);
        $date = mysqli_real_escape_string($conn, $date);
        $time = stripslashes($_REQUEST['time']);
        $time = mysqli_real_escape_string($conn, $time);
        
        $addplayquery = "INSERT INTO `Plays`(
                            `game_id`,
                            `DATE`,
                            `TIME`
                        )
                        VALUES(
                            $gameid,
                            '$date',
                            '$time')";
        $resultaddplayquery = mysqli_query($conn, $addplayquery);
        
        $playid = "select max(id) from Plays";
        $resultplayid = mysqli_query($conn, $playid);
        while($row = $resultplayid->fetch_assoc()) {
            $playid = $row["max(id)"];
        }
    }
    if (isset($_POST['Players1'])) {
        $player1 = $_REQUEST['Players1'];
        $addplayquery2 = "INSERT INTO `Plays_Players_lnk`(`plays_id`, `players_id`)
                         VALUES (
                         $playid,
                         $player1
                         )";
        $resultaddplayquery2 = mysqli_query($conn, $addplayquery2);
    }
    if (isset($_POST['Players2'])) {
        $player2 = $_REQUEST['Players2'];
        $addplayquery2 = "INSERT INTO `Plays_Players_lnk`(`plays_id`, `players_id`)
                         VALUES (
                         $playid,
                         $player2
                         )";
        $resultaddplayquery2 = mysqli_query($conn, $addplayquery2);
    }
    if (isset($_POST['Players3'])) {
        $player3 = $_REQUEST['Players3'];
        $addplayquery2 = "INSERT INTO `Plays_Players_lnk`(`plays_id`, `players_id`)
                         VALUES (
                         $playid,
                         $player3
                         )";
        $resultaddplayquery2 = mysqli_query($conn, $addplayquery2);
    }
    if (isset($_POST['Players4'])) {
        $player4 = $_REQUEST['Players4'];
        $addplayquery2 = "INSERT INTO `Plays_Players_lnk`(`plays_id`, `players_id`)
                         VALUES (
                         $playid,
                         $player4
                         )";
        $resultaddplayquery2 = mysqli_query($conn, $addplayquery2);
    }
    if (isset($_POST['Players5'])) {
        $player5 = $_REQUEST['Players5'];
        $addplayquery2 = "INSERT INTO `Plays_Players_lnk`(`plays_id`, `players_id`)
                         VALUES (
                         $playid,
                         $player5
                         )";
        $resultaddplayquery2 = mysqli_query($conn, $addplayquery2);
    }
    if (isset($_POST['Players6'])) {
        $player6 = $_REQUEST['Players6'];
        $addplayquery2 = "INSERT INTO `Plays_Players_lnk`(`plays_id`, `players_id`)
                         VALUES (
                         $playid,
                         $player6
                         )";
        $resultaddplayquery2 = mysqli_query($conn, $addplayquery2);
    }

?>
<html>
<head>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div id="Banner">
<center><p id="Title">Welcome <?php echo $_SESSION['username'] ?>!</p></center></div>

    <div id="Menu">
        <a href="logout.php">Logout</a>
        <a href="dashboard.php">Homepage</a>
        <a href="addgame.php">Games</a>
        <a href="addplay.php">Plays</a>
        <a href="purchases.php">Purchases</a>
        <a href="kickstarters2.php">Add Kickstarter</a>
    </div> 
    
        <?php
    
    $sql = "SELECT
    Games.name,
    p.DATE,
    p.TIME,
    count(l.plays_id) AS players,
    p.id,
    p.`id` AS gamername,
    MAX(CASE WHEN ps.id = 1 THEN ps.name END) AS Player1,
	MAX(CASE WHEN ps.id = 2 THEN ps.name END) AS Player2,
    MAX(CASE WHEN ps.id = 3 THEN ps.name END) AS Player3,
    MAX(CASE WHEN ps.id = 4 THEN ps.name END) AS Player4,
    MAX(CASE WHEN ps.id = 5 THEN ps.name END) AS Player5,
    MAX(CASE WHEN ps.id = 6 THEN ps.name END) AS Player6,
    MAX(CASE WHEN ps.id = 7 THEN ps.name END) AS Player7,
    MAX(CASE WHEN ps.id = 8 THEN ps.name END) AS Player8,
    MAX(CASE WHEN ps.id = 9 THEN ps.name END) AS Player9,
    MAX(CASE WHEN ps.id = 10 THEN ps.name END) AS Player10,
    MAX(CASE WHEN ps.id = 11 THEN ps.name END) AS Player11,
    MAX(CASE WHEN ps.id = 12 THEN ps.name END) AS Player12
FROM
    Plays_Players_lnk l
LEFT JOIN Plays p ON
    l.plays_id = p.id
LEFT JOIN Players ps ON
    l.players_id = ps.id
LEFT JOIN Games ON p.game_id = Games.id
GROUP BY
    p.`id`
    ORDER BY p.DATE DESC";
$result = $conn->query($sql);
//sql grabs 12 most recent games

echo "<table id='AddGameTable'>";
echo "<tr>";
echo "<th>Game Name</th><th>Date</th><th>Time</th><th>Player Count</th><th></th><th></th>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>". $row["name"]."</center></td>";
        echo "<td><center>". $row["DATE"]."</center></td>";
        echo "<td><center>". $row["TIME"]."</center></td>";
        echo "<td><center>". $row["players"]."</center></td>";
        echo "<td><a href='playoverview.php?id=". $row["id"]."'>View Details</a></td>";
        echo "<td><a onClick=\"javascript:return confirm('Are you sure you want to delete ". $row["name"]."?');\" href='deleteplay.php?id=". $row["id"]."'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

?>

<div id="addplaynewplay">
    <form class="form" method="post" name="newgame">
        <h1 class ="addplaytitle">Add a new play</h1><center>
        <select name = "Games" class="newgame-input">
            <?php 
            
            $sql2 = "select id,name from Games order by collection, name asc ";
            $result2 = $conn->query($sql2);
            
                while($row2 = $result2->fetch_assoc()) {
                    echo "<option value = \"". $row2['id'] . "\">" . $row2['name'] . "</option>";
                }
            ?>
        </select><br>
        Date: <input type="date" value="<?php echo date('Y-m-d'); ?>" name="date" min="2020-01-01"><br>
        Length of Play:
        <input type="time" name="time"><br>

        Number of Players: 
        <select name="noOfPlayers" method="get">
            <option value ="1">1</option>
            <option value ="2">2</option>
            <option value ="3">3</option>
            <option value ="4">4</option>
            <option value ="5">5</option>
            <option value ="6">6</option>
        </select><br><br>
                <?php 
        $x=0;
        while($x<6) {
            $xPlayer = $x + 1;
            echo "Player " . $xPlayer . ": <select name='Players" . $xPlayer . "'>";
            
            $sql3 = "select id,name from Players order by id asc";
            $result3 = $conn->query($sql3);
            
            echo "<option disabled selected value='NULL'>Name</option>";
            
                while($row3 = $result3->fetch_assoc()) {
                    echo "<option value = \"". $row3['id'] . "\">" . $row3['name'] . "</option>";
                } 
                echo "</select><br>";
                $x++;
        }
        echo '<br>';
        echo '<input type="submit" value="AddGame" name="submit" class="login-button"/></center>';
        ?>

  </form>
</div>
    </body>
    </html>