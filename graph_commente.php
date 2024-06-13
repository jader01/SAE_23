<?php
########################################################################################################################
#
#                                                  Connexion à la base de données
#
########################################################################################################################
$db = new SQLite3('database.sqlite'); // Connexion à la base de données SQLite

########################################################################################################################
#
#                                                  Requêtes SQL et traitement des résultats
#
########################################################################################################################
$result = $db->query('SELECT * FROM weather where name="air_temperature"'); // Requête pour obtenir les données de température de l'air
$data = array(); // Création d'un tableau pour stocker les données

while($row = $result->fetchArray()){ // Boucle pour parcourir les résultats de la requête
    $data[] = array("label" => $row['hour'], "y" => $row['value']); // Ajout des données de température au tableau
}

$result1 = $db->query('SELECT * FROM weather where name="air_pressure_at_sea_level"'); // Requête pour obtenir les données de pression atmosphérique
$data1 = array(); // Création d'un tableau pour stocker les données

while($row1 = $result1->fetchArray()){ // Boucle pour parcourir les résultats de la requête
    $data1[] = array("label" => $row1['hour'], "y" => $row1['value']); // Ajout des données de pression au tableau
}

$result2 = $db->query('SELECT * FROM weather where name="cloud_area_fraction"'); // Requête pour obtenir les données de couverture nuageuse
$data2 = array(); // Création d'un tableau pour stocker les données

while($row2 = $result2->fetchArray()){ // Boucle pour parcourir les résultats de la requête
    $data2[] = array("label" => $row2['hour'], "y" => $row2['value']); // Ajout des données de couverture nuageuse au tableau
}

$result3 = $db->query('SELECT * FROM weather where name="relative_humidity"'); // Requête pour obtenir les données d'humidité relative
$data3 = array(); // Création d'un tableau pour stocker les données

while($row3 = $result3->fetchArray()){ // Boucle pour parcourir les résultats de la requête
    $data3[] = array("label" => $row3['hour'], "y" => $row3['value']); // Ajout des données d'humidité au tableau
}

$result4 = $db->query('SELECT * FROM weather where name="wind_from_direction"'); // Requête pour obtenir les données de direction du vent
$data4 = array(); // Création d'un tableau pour stocker les données

while($row4 = $result4->fetchArray()){ // Boucle pour parcourir les résultats de la requête
    $data4[] = array("label" => $row4['hour'], "y" => $row4['value']); // Ajout des données de direction du vent au tableau
}

$result5 = $db->query('SELECT * FROM weather where name="wind_speed"'); // Requête pour obtenir les données de vitesse du vent
$data5 = array(); // Création d'un tableau pour stocker les données

while($row5 = $result5->fetchArray()){ // Boucle pour parcourir les résultats de la requête
    $data5[] = array("label" => $row5['hour'], "y" => $row5['value']); // Ajout des données de vitesse du vent au tableau
}
?>

<!DOCTYPE HTML>
<html>
<head>
<script>
window.onload = function () {
    // Création et rendu du graphique de température
    var chartTemp = new CanvasJS.Chart("chartContainerTemp", {
        animationEnabled: true,
        title: {
            text: "Temperature de Gensac"
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
            dataPoints: <?php echo json_encode($data, JSON_NUMERIC_CHECK); ?> // Ajout des données de température
        }]
    });
    chartTemp.render(); // Rendu du graphique de température

    // Création et rendu du graphique de pression atmosphérique
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
            dataPoints: <?php echo json_encode($data1, JSON_NUMERIC_CHECK); ?> // Ajout des données de pression
        }]
    });
    chartPressure.render(); // Rendu du graphique de pression

    // Création et rendu du graphique de couverture nuageuse
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
            dataPoints: <?php echo json_encode($data2, JSON_NUMERIC_CHECK); ?> // Ajout des données de couverture nuageuse
        }]
    });
    chartCloud.render(); // Rendu du graphique de couverture nuageuse

    // Création et rendu du graphique d'humidité
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
            dataPoints: <?php echo json_encode($data3, JSON_NUMERIC_CHECK); ?> // Ajout des données d'humidité
        }]
    });
    chartHumidity.render(); // Rendu du graphique d'humidité

    // Création et rendu du graphique de direction du vent
    var chartWindDirection = new CanvasJS.Chart("chartContainerWindDirection", {
        animationEnabled: true,
        title: {
            text: "Direction du Vent"
        },
        axisX: {
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        axisY: {
            title: "Direction en fonction du temps",
            includeZero: true,
            crosshair: {
                enabled: true,
                snapToDataPoint: true
            },
        },
        data: [{
            type: "spline",
            dataPoints: <?php echo json_encode($data4, JSON_NUMERIC_CHECK); ?> // Ajout des données de direction du vent
        }]
    });
    chartWindDirection.render(); // Rendu du graphique de direction du vent

    // Création et rendu du graphique de vitesse du vent
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
            dataPoints: <?php echo json_encode($data5, JSON_NUMERIC_CHECK); ?> // Ajout des données de vitesse du vent
        }]
    });
    chartWindSpeed.render(); // Rendu du graphique de vitesse du vent
}
</script>
<script src="https://cdn.canvasjs.com/canvasjs.min.js"></script>
</head>
<body>
    <div id="chartContainerTemp" style="height: 370px; width: 100%;"></div> <!-- Conteneur pour le graphique de température -->
    <div id="chartContainerPressure" style="height: 370px; width: 100%;"></div> <!-- Conteneur pour le graphique de pression -->
    <div id="chartContainerCloud" style="height: 370px; width: 100%;"></div> <!-- Conteneur pour le graphique de couverture nuageuse -->
    <div id="chartContainerHumidity" style="height: 370px; width: 100%;"></div> <!-- Conteneur pour le graphique d'humidité -->
    <div id="chartContainerWindDirection" style="height: 370px; width: 100%;"></div> <!-- Conteneur pour le graphique de direction du vent -->
    <div id="chartContainerWindSpeed" style="height: 370px; width: 100%;"></div> <!-- Conteneur pour le graphique de vitesse du vent -->
</body>
</html>
