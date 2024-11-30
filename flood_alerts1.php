<?php
include 'db_conn.php';
$sql = "SELECT * FROM sensor_data WHERE status = 'NEW' ORDER BY id DESC, timestamp DESC;"; 
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flood Alerts</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
   
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            padding: 8px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4f4f4;
        }
        .trending-up {
            color: #EA3323;
        }
        .trending-down {
            color: #0BA4D7;
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>

<?php
if ($result->num_rows > 0) {
    echo '<table>';
    echo '<thead>
            <tr>
                <th>Flood Alert ID</th>
                <th>Date</th>
                <th>Time</th>
                <th>Status</th>
                <th>Height</th>
                <th>Height Rate</th>
                <th>Flow</th>
                <th>Water Level</th>
                <th>Action</th>
            </tr>
          </thead>';
    echo '<tbody>';

    $rows = $result->fetch_all(MYSQLI_ASSOC); 
    for ($i = 0; $i < count($rows); $i++) {
        $id = $rows[$i]['id'];
        $timestamp = $rows[$i]['timestamp'];
        $meters = $rows[$i]['meters'];
        $speed = $rows[$i]['speed'];
        $alert_level = $rows[$i]['alert_level'];
        $status = $rows[$i]['status'];
        $disabled = $i > 0 ? 'disabled' : '';
        $date = date("m/d/Y", strtotime($timestamp));
        $time = date("g:i:s A", strtotime($timestamp));
        $flow = 'N/A';
        if ($i < count($rows) - 1) { 
            $nextMeters = $rows[$i + 1]['meters'];
            $flow = ($meters > $nextMeters) 
                    ? '<span class="material-symbols-rounded trending-up">trending_up</span>' 
                    : (($meters < $nextMeters) 
                        ? '<span class="material-symbols-rounded trending-down">trending_down</span>' 
                        : 'STABLE');
        }


        $alertMapping = [
            "NORMAL LEVEL" => "NORMAL",
            "LOW LEVEL" => "LOW",
            "MEDIUM LEVEL" => "MODERATE",
            "CRITICAL LEVEL" => "CRITICAL"
        ];
        $mappedAlertLevel = isset($alertMapping[$alert_level]) ? $alertMapping[$alert_level] : $alert_level;

        echo "<tr>
                <td>{$id}</td>
                <td>{$date}</td>
                <td>{$time}</td>
                <td>{$status}</td>
                <td>{$meters}m</td>
                <td>{$speed}m/min</td>
                <td>{$flow}</td>
                <td>{$mappedAlertLevel}</td>
                <td><button {$disabled}>REVIEW ALERT</button></td>
              </tr>";
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo "No data available.";
}

$conn->close();
?>

</body>
</html>
