<?php
require '../db_connection.php';
include("../auth_session.php");
require_once 'StravaApi.php';
?>
<html>
<head>
    <link rel="stylesheet" href="../styles.css">
</head>
<body>
<?php include('../header.php'); ?>
<br><br><br><br>
<table id="stravaIndexTable">
    <tr><th>Activity Name</th><th>Date</th><th>Type</th><th>Distance</th></tr>

<?php

$user_id = $_SESSION['id'];

$query    = "SELECT * FROM `Activities` WHERE user_id = $user_id order by start_date desc";
$result = $conn->query($query);

    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>". $row["activity_name"]."</center></td>";
        echo "<td><center>". $row["start_date"]."</center></td>";
        echo "<td><center>". $row["type"]."</center></td>";    
        echo "<td><center>". $row["distance"]."</center></td>";    
        echo "</tr>";
    }
?>

</table>
</body>
</html>