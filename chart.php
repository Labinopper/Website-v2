<?php
    require 'db_connection.php';
	include("auth_session.php");

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
?>
<html>
<head>
	<!--Load the AJAX API-->
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
	<script type="text/javascript">

		// Load the Visualization API and the corechart package.
		google.charts.load('current', { 'packages': ['corechart'] });

		// Set a callback to run when the Google Visualization API is loaded.
		google.charts.setOnLoadCallback(drawChart);

		// Callback that creates and populates a data table,
		// instantiates the pie chart, passes in the data and
		// draws it.
	function drawChart() {



			// Create the data table.
			var data = new google.visualization.DataTable();
			data.addColumn('string', 'Month');
			data.addColumn('number', 'Number of Games');
			data.addColumn('number','Time')
			"<?php echo 'data.addRow( $row['MONTH'] , $row['COUNT'] , $row['LENGTH'] )';"
			"<?php while ($row = $result2 -> fetch_assoc()) { echo 'data.addRow( $row['MONTH'] , $row['COUNT'] , $row['LENGTH'] )';}; ?> "


			// Set chart options
			var options = {
				'title': 'How Much Pizza I Ate Last Night',
				'width': 400,
				'height': 300
			};

			// Instantiate and draw our chart, passing in some options.
			var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
			chart.draw(data, options);
		}
	</script>
</head>

<body>
	<!--Div that will hold the pie chart-->
	<div id="chart_div"></div>
</body>
</html>