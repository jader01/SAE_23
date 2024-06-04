<?php
    $db = new SQLite3('database.sqlite');
    $result = $db->query('SELECT * FROM weather where name="air_temperature"');
	$data=array();

	while($row = $result->fetchArray()){
		$data[]=array("label" => $row['hour'], "y" => $row['value']);
	}
?>


<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
 
var chart = new CanvasJS.Chart("chartContainer", {
	animationEnabled: true,
	title:{
		text: "Meteo de Gensac"
	},
	axisX: {
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		},
	},
	axisY: {
		title: "Temperature en fonction du temps",
		includeZero: true,
		crosshair: {
			enabled: true,
			snapToDataPoint: true
		},
	},
	data: [{
		type: "spline",
		dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?>
	}]
});
 
chart.render();
 
}
</script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</head>
<body>
<div id="chartContainer" style="height: 370px; width: 100%;"></div>
</body>
</html>       