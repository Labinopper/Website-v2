<?php
require '../../db_connection.php';
include("../auth_session.php");
require_once 'StravaApi.php';
?>

Hello World!
<br><br><br><br>
<table>
    <tr><th>Activity Name</th><th>Date</th><th>Type</th><th>Distance</th></tr>

<?php

$user_id = $_SESSION['id'];

$query    = "SELECT * FROM `Activities` WHERE user_id = $user_id";
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