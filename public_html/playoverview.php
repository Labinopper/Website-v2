<?php
    require '../db_connection.php';
    include("auth_session.php");
    $players = [];
    $id = $_GET['id']; // get id through query string
                $x = 0;
                $query2 = "SELECT
                            *
                        FROM
                            Plays_Players_lnk
                        INNER JOIN Players ON Plays_Players_lnk.players_id = Players.id
                        LEFT JOIN CategoryEntries ON CategoryEntries.id = Plays_Players_lnk.playerchar_id
                        WHERE
                            plays_id = $id";
                $result2 = mysqli_query($conn,$query2);
                $row2 = mysqli_num_rows($result2);
                $x++;
                echo 'Player ID test';
                while ($row2 = $result2->fetch_assoc()) {
                    $players[$x] = $row2["players_id"];
                    echo $players[$x];
                    $x++;

                }
            
    if (isset($_POST['GameScenario'])) {
        $GameScenario = stripslashes($_REQUEST['GameScenario']);    // removes backslashes
        $GameScenario = mysqli_real_escape_string($conn, $GameScenario);
        echo $GameScenario;
        // Check user is exist in the database
        $query    = "UPDATE
                        `Plays`
                    SET
                        `scenario_id` = $GameScenario
                    WHERE
                        id = $id";
        $result2 = mysqli_query($conn, $query);
        echo $query;
    }
            
    if (isset($_POST['GamePlayer1'])) {
        $GamePlayer1 = stripslashes($_REQUEST['GamePlayer1']);    // removes backslashes
        $GamePlayer1 = mysqli_real_escape_string($conn, $GamePlayer1);
        // Check user is exist in the database
        $query    = "UPDATE
                        `Plays_Players_lnk`
                    SET
                        `playerchar_id` = $GamePlayer1
                    WHERE
                        plays_id = $id
                    AND
                        players_id = $players[1]";
        $result = mysqli_query($conn, $query);
        echo $query;
    }
    
    if (isset($_POST['GamePlayer2'])) {
        $GamePlayer2 = stripslashes($_REQUEST['GamePlayer2']);    // removes backslashes
        $GamePlayer2 = mysqli_real_escape_string($conn, $GamePlayer2);
        // Check user is exist in the database
        $query    = "UPDATE
                        `Plays_Players_lnk`
                    SET
                        `playerchar_id` = $GamePlayer2
                    WHERE
                        plays_id = $id
                    AND
                        players_id = $players[2] ";
        $result = mysqli_query($conn, $query);
        echo $query;
    }
    
    if (isset($_POST['GamePlayer3'])) {
        $GamePlayer3 = stripslashes($_REQUEST['GamePlayer3']);    // removes backslashes
        $GamePlayer3 = mysqli_real_escape_string($conn, $GamePlayer3);
        // Check user is exist in the database
        $query    = "UPDATE
                        `Plays_Players_lnk`
                    SET
                        `playerchar_id` = $GamePlayer3
                    WHERE
                        plays_id = $id
                    AND
                        players_id = $players[3] ";
        $result = mysqli_query($conn, $query);
        echo $query;
    }
    
    if (isset($_POST['GamePlayer4'])) {
        $GamePlayer4 = stripslashes($_REQUEST['GamePlayer4']);    // removes backslashes
        $GamePlayer4 = mysqli_real_escape_string($conn, $GamePlayer4);
        // Check user is exist in the database
        $query    = "UPDATE
                        `Plays_Players_lnk`
                    SET
                        `playerchar_id` = $GamePlayer4
                    WHERE
                        plays_id = $id
                    AND
                        players_id = $players[4] ";
        $result = mysqli_query($conn, $query);
        echo $query;
    }
    
    if (isset($_POST['GamePlayer5'])) {
        $GamePlayer5 = stripslashes($_REQUEST['GamePlayer5']);    // removes backslashes
        $GamePlayer5 = mysqli_real_escape_string($conn, $GamePlayer5);
        // Check user is exist in the database
        $query    = "UPDATE
                        `Plays_Players_lnk`
                    SET
                        `playerchar_id` = $GamePlayer5
                    WHERE
                        plays_id = $id
                    AND
                        players_id = $players[5] ";
        $result = mysqli_query($conn, $query);
        echo $query;
    }
    
    if (isset($_POST['GamePlayer6'])) {
        $GamePlayer6 = stripslashes($_REQUEST['GamePlayer6']);    // removes backslashes
        $GamePlayer6 = mysqli_real_escape_string($conn, $GamePlayer6);
        // Check user is exist in the database
        $query    = "UPDATE
                        `Plays_Players_lnk`
                    SET
                        `playerchar_id` = $GamePlayer6
                    WHERE
                        plays_id = $id
                    AND
                        players_id = $players[6] ";
        $result = mysqli_query($conn, $query);
        echo $query;
    }
    
    $mainquery =    "SELECT
                    *,
                    COUNT(Plays_Players_lnk.plays_id) AS Playercount
                FROM
                    `Plays`
                INNER JOIN Games ON Plays.game_id = Games.id
                INNER JOIN Plays_Players_lnk ON Plays.id = Plays_Players_lnk.plays_id
                LEFT JOIN CategoryEntries ON Plays.scenario_id = CategoryEntries.id
                WHERE
                    Plays.id = $id
                LIMIT 1";
    $mainresult = mysqli_query($conn, $mainquery);
    $mainrow = mysqli_num_rows($mainresult);
            while($mainrow = $mainresult->fetch_assoc()) {
                $gameid = $mainrow["game_id"];
                $name = $mainrow["name"];
                $time = $mainrow["TIME"];
                $date = $mainrow["DATE"];
                $scenarioname = $mainrow["title"];
                $scenarioid = $mainrow["scenario_id"];
                $pcount = $mainrow["Playercount"];
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
    </div>
    <div id="GOTitle">
    <?php echo $name; ?>
    </div>
    <table id="GOCustomTable1">
    <?php
        $x = 0;
        echo '<tr><td>Game:</td><td>'.$name.'</td>';
            if(is_null($scenarioid)) {
                echo '<td>No Scenario Set</td>';
                }
            else {
                echo '<td>'.$scenarioname.'</td>';
                    }
        echo '</tr>';
        echo '<tr><td>Duration:</td><td>'.$time.'</td><td></td></tr>';
        echo '<tr><td>Date:</td><td>'.$date.'</td><td></td></tr>';
            if($x < $pcount) {
                $query2 = "SELECT
                            *
                        FROM
                            Plays_Players_lnk
                        INNER JOIN Players ON Plays_Players_lnk.players_id = Players.id
                        LEFT JOIN CategoryEntries ON CategoryEntries.id = Plays_Players_lnk.playerchar_id
                        WHERE
                            plays_id = $id";
                $result2 = mysqli_query($conn,$query2);
                $row2 = mysqli_num_rows($result2);
                $x++;

                echo 'Player ID test';
                while ($row2 = $result2->fetch_assoc()) {
                    $players[$x] = $row2["players_id"];
                    echo '<tr><td>Player '.$x.':</td><td>'.$row2["name"].'</td><td>'.$row2["title"].'</td>';
                    echo '</tr>';
                    $x++;
                }
            }
    ?>
    </table>
    
    <form id='POAddCategoryMain' method="POST">
        Scenario: <select name = "GameScenario" class="newgame-input">
            <?php 
            
            $sql2 = "SELECT
                        *
                    FROM
                        GameCategory
                    left JOIN CategoryEntries ON GameCategory.id = CategoryEntries.category_id
                    WHERE
                        GameCategory.game_id = $gameid AND categorytype = 'Scenario'";
            $result2 = $conn->query($sql2);
            $row2 = mysqli_num_rows($result2);
            echo "<option value=0 selected='true' disabled default></option>";
            if($row2>0) {
                while($row2 = $result2->fetch_assoc()) {
                    echo "<option value = \"". $row2['id'] . "\">" . $row2['title'] . "</option>";
                }
            }
            else {
                echo "<option value=0 diasbled>No Scenarios set</option>";
            }
            ?>
        </select>
        <?php
        $y = 0;
            while($y<$pcount) {
                    $y++;
                    echo 'Player '.$y.': <select name = "GamePlayer'.$y.'" class="newgame-input">';
                    $sql3 = "SELECT
                                *
                            FROM
                                GameCategory
                            left JOIN CategoryEntries ON GameCategory.id = CategoryEntries.category_id
                            WHERE
                                GameCategory.game_id = $gameid AND categorytype = 'PlayerChar'";
                    $result3 = $conn->query($sql3);
                    $row3 = mysqli_num_rows($result3);
                    echo "<option value=0 selected='true' disabled></option>";
                    if($row3>0) {
                        while($row3 = $result3->fetch_assoc()) {
                            echo "<option value = \"". $row3['id'] . "\">" . $row3['title'] . "</option>";
                        }
                    }
            else {
                echo "<option value=0 diasbled>No Characters set</option>";
            }
                    echo '</select>';
            }
        ?>
        <input type="submit" value="Assign Scenario" name="AssignScenario" onclick="return confirm('Are you sure?')">
    </form>
    </body>
    </html>