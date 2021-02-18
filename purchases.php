<?php
    require 'db_connection.php';
    include("auth_session.php");

    // When form submitted, check and create user session.
    require 'db_connection.php';
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
    
        if (isset($_POST['comment']) && isset($_POST['cost']) && isset($_POST['gift']) && isset($_POST['Games']) && isset($_POST['date'])) {
        $gameName = stripslashes($_REQUEST['Games']);    // removes backslashes
        $gameName = mysqli_real_escape_string($conn, $gameName);
        $comment = stripslashes($_REQUEST['comment']);
        $comment = mysqli_real_escape_string($conn, $comment);
        $cost = stripslashes($_REQUEST['cost']);
        $cost = mysqli_real_escape_string($conn, $cost);
        $date = stripslashes($_REQUEST['date']);
        $date = mysqli_real_escape_string($conn, $date);
        $gift = stripslashes($_REQUEST['gift']);
        $gift = mysqli_real_escape_string($conn, $gift);
        $addpurchasequery = "INSERT INTO `Purchases`(
                                `Comment`,
                                `game_id`,
                                `gift`,
                                `Cost`,
                                `Delivery Date`
                            )
                            VALUES(
                                '$comment',
                                '$gameName',
                                '$gift',
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
    Purchases.*,
    Games.name,
    Games.collection
FROM
    `Purchases`
LEFT JOIN Games ON Purchases.game_id = Games.id
ORDER BY
    Games.collection,
    Games.name
DESC
    ,
    Purchases.id
DESC
    ";
    $result = $conn->query($sql);
    //sql grabs 12 most recent games

echo "<table id='AddGameTable'>";
echo "<tr>";
echo "<th>Date</th><th>Comment</th><th>Name</th><th>Collection</th><th>Cost</th><th>Gift?</th><th>Delete</th>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>". $row["Delivery Date"]."</center></td>";
        echo "<td><center>". $row["Comment"]."</center></td>";
        echo "<td><center>". $row["name"]."</center></td>";
        echo "<td><center>". $row["collection"]."</center></td>";
        $cost = sprintf("%02d",$row["Cost"]);
        echo "<td><center>£". number_format($cost,2,'.',' ')."</center></td>";
        if($row["gift"] === 'Y') {
            echo "<td><center>&#10004;</center></td>";
        }
        else {
            echo "<td></td>";
        }
        echo "<td><a onClick=\"javascript:return confirm('Are you sure you want to delete your purchase of ". $row["Comment"]." from ". $row["name"]."?');\" href='deletepurchase.php?id=". $row["id"]."'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>


<div id='addpurchasenewpurchase'>
    <form class="form" method="post" name="newpurchase">
        <h1 class ="addpurchase">Add a new Purchase</h1>
        <select name = "Games" class="newgame-input">
            <?php 
            
            $sql2 = "select id,name from Games order by collection, name asc ";
            $result2 = $conn->query($sql2);
            
                while($row2 = $result2->fetch_assoc()) {
                    echo "<option value = \"". $row2['id'] . "\">" . $row2['name'] . "</option>";
                }
            ?>
        </select>
        <input type="comment" class="newgame-input" name="comment" placeholder="Type of Purchase" autofocus="true"/><br>
        <input type="number" class="newgame-input" name="cost" placeholder="Cost" step = "0.01" /><br>Is this a gift?<br>
        <input type ="radio" class ="newgame-radio" value="Y" name="gift">Yes</input>
        <input type ="radio" class ="newgame-radio" value="N" name="gift" checked>No</input><br>
        <input type="date" class="newgame-date" value="<?php echo date('Y-m-d'); ?>" name="date" min="2020-01-01"><br><br>

        <input type="submit" value="AddGame" name="submit" class="login-button"/>
        <?php echo "<p id='error'> $gameexists </p>" ?>
  </form>
</div>

    
    </body>
    </html>