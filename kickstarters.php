<?php
    require 'db_connection.php';
    include("auth_session.php");

    // When form submitted, check and create user session.
    $gameexists = "";
    
        if (isset($_POST['comment']) && isset($_POST['cost']) && isset($_POST['Games'])) {
        $comment = stripslashes($_REQUEST['comment']);
        $comment = mysqli_real_escape_string($conn, $comment);
        $cost = stripslashes($_REQUEST['cost']);
        $cost = mysqli_real_escape_string($conn, $cost);
        $paid = stripslashes($_REQUEST['paid']);
        $paid = mysqli_real_escape_string($conn, $paid);
        $ks = stripslashes($_REQUEST['Games']);
        $ks = mysqli_real_escape_string($conn, $ks);
        $getgameid = "select game_id from Kickstarters where id = $ks";
        $resultgameid = $conn->query($getgameid);
        while($row = $resultgameid->fetch_assoc()) {
            $game_id = $row["game_id"];
        }
        $addpurchasequery = "INSERT INTO `Purchases`(
                                `Comment`,
                                `game_id`,
                                `Cost`,
                                `ks_id`,
                                `paid`
                            )
                            VALUES(
                                '$comment',
                                '$game_id',
                                '$cost',
                                '$ks',
                                '$paid'
                            )";
                            echo $addpurchasequery;
        $resultpurchasequery = mysqli_query($conn, $addpurchasequery);
        }
?>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include('header.php'); ?>

    
    <div id="AddNewKS">
            <form class="form" method="post" name="newks">
        <h1 class ="addpurchase"><center>New Kickstarter</center></h1>
        <select name = "Games" class="newks-input">
            <?php 
            
            $sql2 = "SELECT
                        Kickstarters.id,
                        Games.name
                    FROM
                        Kickstarters
                    inner join Games
                    on Kickstarters.game_id = Games.id
                    ORDER BY
                        Games.collection,
                        Games.name ASC";
            $result2 = $conn->query($sql2);
            
                while($row2 = $result2->fetch_assoc()) {
                    echo "<option value = \"". $row2['id'] . "\">" . $row2['name'] . "</option>";
                }
            ?>
        </select>
        <input type="comment" class="newks-input" name="comment" placeholder="Item" autofocus="true"/>
        <input type="number" class="newks-input" name="cost" placeholder="Cost" step = "0.01" /><span class="ksrdaio">Paid?
        <input type="radio" id="newks-radio" value="Y" name="paid">Yes</input>
        <input type="radio" id="newks-radio" value="N" name="paid" checked>No</input>
        </span><br><br><br>
        <input type="submit" value="Add Game" name="submit" class="newks-submit"/>
  </form>
    </div>
    
    
    
    
        <?php
    
    $sql = "SELECT
    Purchases.*,
    Games.name,
    Games.collection
FROM
    `Purchases`
LEFT JOIN Games ON Purchases.game_id = Games.id
WHERE
    paid IS NOT NULL
ORDER BY
    Purchases.paid,
    Games.collection,
    Games.name,
    Purchases.Comment
ASC
    ";
    $result = $conn->query($sql);
    //sql grabs 12 most recent games

echo "<table id='AddGameTableKS'>";
echo "<tr>";
echo "<th>Comment</th><th>Name</th><th>Collection</th><th>Paid?</th><th>Cost</th><th>Delete</th>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>". $row["Comment"]."</center></td>";
        echo "<td><center>". $row["name"]."</center></td>";
        echo "<td><center>". $row["collection"]."</center></td>";
        echo "<td><center>". $row["paid"]."</center></td>";
        $cost = sprintf("%02d",$row["Cost"]);
        echo "<td><center>£". number_format($cost,2,'.',' ')."</center></td>";
        echo "<td><a onClick=\"javascript:return confirm('Are you sure you want to delete your purchase of ". $row["Comment"]." from ". $row["name"]."?');\" href='deletekickstarter.php?id=". $row["id"]."'>Delete</a></td>";
        
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>

    
    </body>
    </html>