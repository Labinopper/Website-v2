<?php
    require 'db_connection.php';
    include("auth_session.php");

    // When form submitted, check and create user session.
    require 'db_connection.php';
    $gameexists = "";
        if(isset($_GET['id'])) {
            $id = $_GET['id']; // get id through query string
        }

    
        if (isset($_POST['Games']) && isset($_POST['deliverydate'])) {
        $gameName = stripslashes($_REQUEST['Games']);    // removes backslashes
        $gameName = mysqli_real_escape_string($conn, $gameName);
        $deliverydate = stripslashes($_REQUEST['deliverydate']);
        $deliverydate = mysqli_real_escape_string($conn, $deliverydate);
        $progress = stripslashes($_REQUEST['progress']);
        $progress = mysqli_real_escape_string($conn, $progress);
        $pm = stripslashes($_REQUEST['pm']);
        $pm = mysqli_real_escape_string($conn, $pm);
        $pmopendate = stripslashes($_REQUEST['pmopendate']);
        $pmopendate = mysqli_real_escape_string($conn, $pmopendate);
        $pmclosedate = stripslashes($_REQUEST['pmclosedate']);
        $pmclosedate = mysqli_real_escape_string($conn, $pmclosedate);
        $addpurchasequery = "INSERT INTO `Kickstarters`(
                                `game_id`,
                                `pm`,
                                `pmopens`,
                                `pmcloses`,
                                `progress`,
                                `delivery_date`
                            )
                            VALUES(
                                '$gameName',
                                '$pm',
                                '$pmopendate',
                                '$pmclosedate',
                                '$progress',
                                '$deliverydate'
                            )";
        $resultpurchasequery = mysqli_query($conn, $addpurchasequery);
        }
?>
<html>
<head>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include('header.php');
 
    if(isset($_GET['id'])) {
        ?>
        <div id="AddNewKS">
            <form class="form" method="post" name="newks">
        <h1 class ="addpurchase"><center>New Kickstarter</center></h1>
        <select name = "Games" class="ksinput">
            <?php 
            
            $sql2 = "select * from Games left join Kickstarters on Kickstarters.game_id = Games.id where Kickstarters.id = $id";
            $result2 = $conn->query($sql2);
            
                while($row2 = $result2->fetch_assoc()) {
                    echo "<option value = \"". $row2['id'] . "\">" . $row2['name'] . "</option>";

            ?>
        </select>
        <input type="comment" class="ksinput" name="pm" placeholder="Pledge Manager">
        <?php echo '<span id="ksdate1">PM Opens:<input type="date" class="newks-date" value="'.$row2['pmopens'].'" name="pmopendate" min="2020-01-01"></span>';
        echo '<span id="ksdate2">PM Closes:<input type="date" class="newks-date" value="'.$row2['pmcloses'].'" name="pmclosedate" min="2020-01-01"></span>';
        echo '<span id="ksdate3">Delivery Date:<input type="date" class="newks-date" value="'.$row2['delivery_date'].'" name="deliverydate" min="2020-01-01"></span>';
        if($row2["progress"] === "A") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A" selected="selected">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row2["progress"] === "B") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B" selected="selected">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row2["progress"] === "C") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C" selected="selected">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row2["progress"] === "D") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D" selected="selected">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row2["progress"] === "E") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E" selected="selected">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row2["progress"] === "F") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F" selected="selected">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row2["progress"] === "G") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G" selected="selected">Delivered</option>';
            echo '</select></center></td>';
        };

        ?>
        <br><br><br>
        <input type="submit" value="Add Game" name="submit" class="newks-submit"/>
    </form>
    </div>
    <?php
    }
    else {
    ?>
    <div id="AddNewKS">
            <form class="form" method="post" name="newks">
        <h1 class ="addpurchase"><center>New Kickstarter</center></h1>
        <select name = "Games" class="ksinput">
            <?php 
            
            $sql2 = "select id,name from Games order by collection, name asc ";
            $result2 = $conn->query($sql2);
            
                while($row2 = $result2->fetch_assoc()) {
                    echo "<option value = \"". $row2['id'] . "\">" . $row2['name'] . "</option>";
                }
            ?>
        </select>
        <input type="comment" class="ksinput" name="pm" placeholder="Pledge Manager">
        <span id="ksdate1">PM Opens:<input type="date" class="newks-date" value="2021-01-01" name="pmopendate" min="2020-01-01"></span>
        <span id="ksdate2">PM Closes:<input type="date" class="newks-date" value="2021-01-01" name="pmclosedate" min="2020-01-01"></span>
        <span id="ksdate3">Delivery Date:<input type="date" class="newks-date" value="<?php echo date('Y-m-d'); ?>" name="deliverydate" min="2020-01-01"></span>
        <select id = "ksprogress" name="progress">
            <option value="A" selected="selected">Coming Soon</option>
            <option value="B">KS Open</option>
            <option value="C">Pleged on KS</option>
            <option value="D">PM Open</option>
            <option value="E">Pledge Finalised</option>
            <option value="F">Money Taken</option>
            <option value="G">Delivered</option>
        </select>
        <br><br><br>
        <input type="submit" value="Add Game" name="submit" class="newks-submit"/>
  </form>
    </div>
<?php
    }

    $sql = "SELECT
    Kickstarters.*,
    SUM(Purchases.cost) AS cost,
    Games.name,
    Games.collection
FROM
    Kickstarters
LEFT JOIN Games ON Kickstarters.game_id = Games.id
LEFT JOIN Purchases ON Kickstarters.id = Purchases.ks_id
group by game_id
order by Kickstarters.delivery_date";
    $result = $conn->query($sql);
    //sql grabs 12 most recent games

echo "<table id='AddGameTableKS'>";
echo "<tr>";
echo "<th>Name</th><th>Collection</th><th>PM</th><th>PM Opens</th><th>PM Closes</th><th>Progress</th><th>Cost</th><th>Delivery Date</th><th>Update</th><th>Delete</th>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>". $row["name"]."</center></td>";
        echo "<td><center>". $row["collection"]."</center></td>";
        echo "<td><center>". $row["pm"]."</center></td>";
        if($row["pmopens"] === "2021-01-01") {
            echo "<td></td>";
        }
        else {
            echo "<td><center>". $row["pmopens"]."</center></td>";
        }
        if($row["pmcloses"] === "2021-01-01") {
            echo "<td></td>";
        }
        else {
            echo "<td><center>". $row["pmcloses"]."</center></td>";
        }
        if($row["progress"] === "A") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A" selected="selected">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row["progress"] === "B") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B" selected="selected">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row["progress"] === "C") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C" selected="selected">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row["progress"] === "D") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D" selected="selected">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row["progress"] === "E") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E" selected="selected">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row["progress"] === "F") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F" selected="selected">Money Taken</option>';
            echo '<option value="G">Delivered</option>';
            echo '</select></center></td>';
        }
        if($row["progress"] === "G") {
            echo '<td><center><select name = "progress">';
            echo '<option value="A">Coming Soon</option>';
            echo '<option value="B">KS Open</option>';
            echo '<option value="C">Pleged on KS</option>';
            echo '<option value="D">PM Open</option>';
            echo '<option value="E">Pledge Finalised</option>';
            echo '<option value="F">Money Taken</option>';
            echo '<option value="G" selected="selected">Delivered</option>';
            echo '</select></center></td>';
        }
        $cost = sprintf("%02d",$row["cost"]);
        echo "<td><center>£". number_format($cost,2,'.',' ')."</center></td>";
        echo "<td><center>". $row["delivery_date"]."</center></td>";
        echo "<td><center><a href='kickstarters2.php?id=". $row["id"]."'>Update</a></center></td>";
        echo "<td><a onClick=\"javascript:return confirm('Are you sure you want to delete your purchase of ". $row["name"]."?');\" href='deletekickstart.php?id=". $row["id"]."'>Delete</a></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
?>

    
    </body>
    </html>