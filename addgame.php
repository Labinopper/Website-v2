<?php
    require 'db_connection.php';
    include("auth_session.php");

    // When form submitted, check and create user session.
    $gameexists = "";
    if (isset($_POST['name']) && isset($_POST['collection'])) {
        $name = stripslashes($_REQUEST['name']);    // removes backslashes
        $name = mysqli_real_escape_string($conn, $name);
        $collection = stripslashes($_REQUEST['collection']);
        $collection = mysqli_real_escape_string($conn, $collection);
        // Check user is exist in the database
        $query    = "SELECT * FROM `Games` WHERE name='$name'";
        $result2 = mysqli_query($conn, $query);
        $rows = mysqli_num_rows($result2);
        if ($rows == 1) {
            $gameexists = "This game already exists!";
        } else {
            $addquery = "INSERT INTO `Games`(`name`, `collection`)
                        VALUES ( '$name', '$collection' )";
            $resultaddquery = mysqli_query($conn, $addquery);
        }
    }
    
        if (isset($_POST['comment']) && isset($_POST['cost']) && isset($_POST['delivered']) && isset($_POST['Games']) && isset($_POST['owned']) && isset($_POST['date'])) {
        $gameName = stripslashes($_REQUEST['Games']);    // removes backslashes
        $gameName = mysqli_real_escape_string($conn, $gameName);
        $comment = stripslashes($_REQUEST['comment']);
        $comment = mysqli_real_escape_string($conn, $comment);
        $cost = stripslashes($_REQUEST['cost']);
        $cost = mysqli_real_escape_string($conn, $cost);
        $date = stripslashes($_REQUEST['date']);
        $date = mysqli_real_escape_string($conn, $date);
        $owned = stripslashes($_REQUEST['owned']);
        $owned = mysqli_real_escape_string($conn, $owned);
        $delivered = stripslashes($_REQUEST['delivered']);
        $delivered = mysqli_real_escape_string($conn, $delivered);
        $addpurchasequery = "INSERT INTO `Purchases`(
                                `Comment`,
                                `game_id`,
                                `Owned`,
                                `Delivered`,
                                `Cost`,
                                `Delivery Date`
                            )
                            VALUES(
                                '$comment',
                                '$gameName',
                                '$owned',
                                '$delivered',
                                '$cost',
                                '$date'
                            )";
        $resultpurchasequery = mysqli_query($conn, $addpurchasequery);
        }
?>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include('header.php'); ?>

    
        <?php
    
    $sql = "SELECT
                T1.id AS id,
                T1.name AS name,
                T1.collection AS collection,
                T1.count AS Count,
                T1.length AS LENGTH,
                SUM(Purchases.Cost) AS cost
            FROM
                (
                SELECT
                    Games.id AS id,
                    Games.name AS NAME,
                    Games.collection AS collection,
                    COUNT(Plays.game_id) AS COUNT,
                    SUM(TIME_TO_SEC(Plays.TIME)) AS LENGTH
                FROM
                    `Games`
                LEFT JOIN Plays ON Games.id = Plays.game_id
                GROUP BY
                    Games.name
                ORDER BY NAME ASC
            ) AS T1
            LEFT JOIN Purchases ON Purchases.game_id = T1.id
            GROUP BY
                T1.name
            ORDER BY
                T1.collection ASC,
                T1.name ASC";
    $result = $conn->query($sql);
    //sql grabs 12 most recent games

echo "<table id='AddGameTable'>";
echo "<tr>";
echo "<th>Game Name</th><th>Game collection</th><th>Times played</th><th>Duration</th><th>Cost</th><th>Cost P/H</th><th></th><th></th></tr>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        if($row["LENGTH"] === NULL) {
            $row["LENGTH"] = 0;
        }
        if($row["cost"] === NULL) {
            $row["cost"] = 0.00;
        }
        echo "<tr>";
        echo "<td><center>". $row["name"]."</center></td>";
        echo "<td><center>". $row["collection"]."</center></td>";
        echo "<td><center>". $row["Count"]."</center></td>";
        $hours = sprintf("%02d",floor($row["LENGTH"] / 3600));
        $minutes = sprintf("%02d",floor($row["LENGTH"] / 60 % 60));
        $cost = sprintf("%02d",$row["cost"]);
        echo "<td><center>$hours:$minutes</center></td>";
        echo "<td><center>£". number_format($cost,2,'.',' ')."</center></td>";
        if($row["cost"] === NULL || $row["cost"] === 0 ) {
            $costPerHour = 0.00;
            echo "<td><center>£". number_format($costPerHour,2,'.',' ')."</center></td>";
        }
        else if($row["LENGTH"] === NULL || $row["LENGTH"] === 0) {
            $costPerHour = $cost / 1;
            echo "<td><center>£". number_format($costPerHour,2,'.',' ')."</center></td>";
        }
        else {
            $costPerHour = $cost / ($row["LENGTH"] / 3600);
            echo "<td><center>£". number_format($costPerHour,2,'.',' ')."</center></td>";
        }
        echo "<td><center><a href='gameoverview.php?id=". $row["id"]."'>Details</a></center></td>";
        echo "<td><center><a onClick=\"javascript:return confirm('Are you sure you want to delete ". $row["name"]."?');\" href='deletegame.php?id=". $row["id"]."'>Delete</a></center></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>

<script>
    function addPurchase(){
    var comment = prompt("Please enter comment for purchase:", "");
}
</script>

<div id='addgamenewgame'>
    <form class="form" method="post" name="newgame">
        <h1 class ="addgametitle">Add a new game</h1>
        <input type="text" class="newgame-input" name="name" placeholder="Game Name" autofocus="true"/><br>
        <input type="text" class="newgame-input" name="collection" placeholder="Collection"/><br><br>
        <input type="submit" value="Add new game" name="submit" class="login-button"/>
        <?php echo "<p id='error'> $gameexists </p>" ?>
  </form>
</div>
    </body>
    </html>