<?php
    require 'db_connection.php';
    include("auth_session.php");
?>
<html>
<head>
  <link rel="stylesheet" href="styles.css">
</head>
<body>
<?php include('header.php'); ?>

    
    <?php
    
    $sql = "SELECT Games.name,Plays.DATE, Plays.TIME,count(Plays_Players_lnk.plays_id) AS players FROM `Games`
            inner join Plays
            on Games.id = Plays.game_id
            left join Plays_Players_lnk on Plays_Players_lnk.plays_id = Plays.id
            group by Plays.id
            Order by Plays.DATE desc
            limit 12";
$result = $conn->query($sql);
//sql grabs 12 most recent games

    $sql2 = "SELECT DISTINCT
            DATE_FORMAT(DATE, '%M %Y') AS MONTH,
            COUNT(*) AS COUNT,
            SUM(TIME_TO_SEC(TIME)) AS LENGTH
            FROM
            Plays
            GROUP BY
            MONTH
            ORDER BY
            DATE
            DESC
            LIMIT 12;";
    $result2 = $conn->query($sql2);
    //sql2 grabs monthly breakdown
    
    $sql3 = "SELECT DISTINCT
            DATE_FORMAT(DATE, '%Y') AS YEAR,
            COUNT(*) AS COUNT,
            SUM(TIME_TO_SEC(TIME)) AS LENGTH
            FROM
            Plays
            GROUP BY
            YEAR
            ORDER BY
            DATE
            DESC
            LIMIT 12;";
    $result3 = $conn->query($sql3);
    //sql grabs yearly breakdown

echo "<table id='GameTable'>";
echo "<tr>";
echo "<th>Game Name</th><th>Date</th><th>Time</th><th>Player Count</th>";
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>". $row["name"]."</center></td>";
        echo "<td><center>". $row["DATE"]."</center></td>";
        echo "<td><center>". $row["TIME"]."</center></td>";
        echo "<td><center>". $row["players"]."</center></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

    echo "<table id='GameTable2'>";
    echo "<tr>";
    echo "<th>Month</th><th>Games</th><th>Duration</th>";
    if ($result2->num_rows > 0) {
    // output data of each row
    while($row = $result2->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>". $row["MONTH"]."</center></td>";
        echo "<td><center>". $row["COUNT"]."</center></td>";
        $hours = sprintf("%02d",floor($row["LENGTH"] / 3600));
        $minutes = sprintf("%02d",floor($row["LENGTH"] / 60 % 60));
        $seconds = sprintf("%02d",floor($row["LENGTH"] % 60));
        echo "<td><center>$hours:$minutes:$seconds</center></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

    echo "<table id='GameTable3'>";
    echo "<tr>";
    echo "<th>Year</th><th>Games</th><th>Duration</th>";
    if ($result3->num_rows > 0) {
    // output data of each row
    while($row = $result3->fetch_assoc()) {
        echo "<tr>";
        echo "<td><center>". $row["YEAR"]."</center></td>";
        echo "<td><center>". $row["COUNT"]."</center></td>";
        $hours = sprintf("%02d",floor($row["LENGTH"] / 3600));
        $minutes = sprintf("%02d",floor($row["LENGTH"] / 60 % 60));
        $seconds = sprintf("%02d",floor($row["LENGTH"] % 60));
        echo "<td><center>$hours:$minutes:$seconds</center></td>";
        echo "</tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}
    ?>
    
</body>
</html>