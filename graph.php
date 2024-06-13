<?php
    $db = new SQLite3('database.sqlite');
    $result = $db->query('SELECT * FROM weather where name="air_temperature"');
	$data=array();

	while($row = $result->fetchArray()){
		$data[]=array("label" => $row['hour'], "y" => $row['value']);
	}

	$result1 = $db->query('SELECT * FROM weather where name="air_pressure_at_sea_level"');
	$data1=array();

	while($row1 = $result1->fetchArray()){
		$data1[]=array("label" => $row1['hour'], "y" => $row1['value']);
	}

	$result2 = $db->query('SELECT * FROM weather where name="cloud_area_fraction"');
	$data2=array();

	while($row2 = $result2->fetchArray()){
		$data2[]=array("label" => $row2['hour'], "y" => $row2['value']);
	}

	$result3 = $db->query('SELECT * FROM weather where name="relative_humidity"');
	$data3=array();

	while($row3 = $result3->fetchArray()){
		$data3[]=array("label" => $row3['hour'], "y" => $row3['value']);
	}

	$result4 = $db->query('SELECT * FROM weather where name="wind_from_direction"');
	$data4=array();

	while($row4 = $result4->fetchArray()){
		$data4[]=array("label" => $row4['hour'], "y" => $row4['value']);
	}

	$result5 = $db->query('SELECT * FROM weather where name="wind_speed"');
	$data5=array();

	while($row5 = $result5->fetchArray()){
		$data5[]=array("label" => $row5['hour'], "y" => $row5['value']);
	}
?>


<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
    var chartTemp = new CanvasJS.Chart("chartContainerTemp", {
        animationEnabled: true,
        title: {
            text: "Meteo de Gensac"
        },
        axisX: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        axisY: {
            title: "Température en fonction du temps",
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
    chartTemp.render();

    var chartPressure = new CanvasJS.Chart("chartContainerPressure", {
        animationEnabled: true,
        title: {
            text: "Pression Atmosphérique"
        },
        axisX: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        axisY: {
            title: "Pression en fonction du temps",
            includeZero: true,
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        data: [{
            type: "spline",
            dataPoints: <?php echo json_encode($data1, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chartPressure.render();

    var chartCloud = new CanvasJS.Chart("chartContainerCloud", {
        animationEnabled: true,
        title: {
            text: "Couverture Nuageuse"
        },
        axisX: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        axisY: {
            title: "Couverture Nuageuse en fonction du temps",
            includeZero: true,
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        data: [{
            type: "spline",
            dataPoints: <?php echo json_encode($data2, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chartCloud.render();

    var chartHumidity = new CanvasJS.Chart("chartContainerHumidity", {
        animationEnabled: true,
        title: {
            text: "Humidité"
        },
        axisX: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        axisY: {
            title: "Humidité en fonction du temps",
            includeZero: true,
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        data: [{
            type: "spline",
            dataPoints: <?php echo json_encode($data3, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chartHumidity.render();


    var chartWindSpeed = new CanvasJS.Chart("chartContainerWindSpeed", {
        animationEnabled: true,
        title: {
            text: "Vitesse du Vent"
        },
        axisX: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        axisY: {
            title: "Vitesse en fonction du temps",
            includeZero: true,
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        data: [{
            type: "spline",
            dataPoints: <?php echo json_encode($data5, JSON_NUMERIC_CHECK); ?>
        }]
    });
    chartWindSpeed.render();
}
</script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</head>
<body>
    <div id="chartContainerTemp" style="height: 370px; width: 100%;"></div>
    <div id="chartContainerPressure" style="height: 370px; width: 100%;"></div>
    <div id="chartContainerCloud" style="height: 400px; width: 100%;"></div>
    <div id="chartContainerHumidity" style="height: 370px; width: 100%;"></div>
    <div id="chartContainerWindSpeed" style="height: 370px; width: 100%;"></div>
</body>
</html>
    