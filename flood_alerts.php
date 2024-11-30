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
        .stable {
            color: #808080;
        }
        button:disabled {
            background-color: #ccc;
            cursor: not-allowed;
        }
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
            justify-content: center;
            align-items: center;
        }
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 50%;
            max-width: 50%;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
        }
        .clicked {
        background-color: #444; 
        color: #fff;
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
    $defaultMeter = 1.0; 

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


        if ($i == 0) {
            $flow = ($meters > $defaultMeter) 
                    ? '<span class="material-symbols-rounded trending-up">trending_up</span>' 
                    : (($meters < $defaultMeter) 
                        ? '<span class="material-symbols-rounded trending-down">trending_down</span>' 
                        : '<span class="material-symbols-rounded stable">stable</span>');
        } else {
            $nextMeters = $rows[$i + 1]['meters'] ?? $defaultMeter;
            $flow = ($meters > $nextMeters) 
                    ? '<span class="material-symbols-rounded trending-up">trending_up</span>' 
                    : (($meters < $nextMeters) 
                        ? '<span class="material-symbols-rounded trending-down">trending_down</span>' 
                        : '<span class="material-symbols-rounded stable">stable</span>');
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
                <td>{$meters} m</td>
                <td>{$speed} m/min</td>
                <td>{$flow}</td>
                <td>{$mappedAlertLevel}</td>
                <td><button onclick='openModal()' {$disabled}>REVIEW ALERT</button></td>
              </tr>";
    }

    echo '</tbody>';
    echo '</table>';
} else {
    echo "No data available.";
}

$conn->close();
?>













<!-- Modal t_t -->
<div id="alertModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal()">&times;</span>
        <p>SUMMARY</p>
        <table>
            <thead>
                <tr>
                    <th>Flood Alert ID</th>
                    <th>Flood Alert Status</th>
                    <th>SMS Status</th>
                    <th>SMS Status Reason</th>
                </tr>
            </thead>
            <tbody id="summaryTableBody">
                <?php
                if ($result->num_rows > 0) {
                    foreach ($rows as $row) {
                        $id = $row['id']; 
                        echo "<tr id='row_{$id}'>
                                <td>{$id}</td>
                                <td id='status_{$id}'></td>
                                <td id='sms_{$id}'></td>
                                <td id='sms_reason_{$id}'></td>
                              </tr>";
                    }
                }
                ?>
            </tbody>
        </table>
                <button>Cancel</button>
                <button>Confirm</button>



        <p>VERIFY THE FLOOD ALERT(S) BELOW:</p>
        <table>
            <thead>
                <tr>
                    <th>Flood Alert ID</th>
                    <th>Date</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Height</th>
                    <th>Height Rate</th>
                    <th>Flow</th>
                    <th>Water Level</th>
                    <th>Mark As:</th>
                </tr>
            </thead>
            <tbody>

<?php
if ($result->num_rows > 0) {

    foreach ($rows as $index => $row) {  
        $id = $row['id'];
        $timestamp = $row['timestamp'];
        $meters = $row['meters'];
        $speed = $row['speed'];
        $alert_level = $row['alert_level'];
        $status = $row['status'];
        $date = date("m/d/Y", strtotime($timestamp));
        $time = date("g:i:s A", strtotime($timestamp));


        if ($index == 0) {

            $flow = ($meters > $defaultMeter) 
                    ? '<span class="material-symbols-rounded trending-up">trending_up</span>' 
                    : (($meters < $defaultMeter) 
                        ? '<span class="material-symbols-rounded trending-down">trending_down</span>' 
                        : '<span class="material-symbols-rounded stable">stable</span>');
        } else {

            $nextMeters = $rows[$index + 1]['meters'] ?? $defaultMeter;
            $flow = ($meters > $nextMeters) 
                    ? '<span class="material-symbols-rounded trending-up">trending_up</span>' 
                    : (($meters < $nextMeters) 
                        ? '<span class="material-symbols-rounded trending-down">trending_down</span>' 
                        : '<span class="material-symbols-rounded stable">stable</span>');
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
                <td>{$meters} m</td>
                <td>{$speed} m/min</td>
                <td>{$flow}</td>
                <td>{$mappedAlertLevel}</td>
                <td>
                    <button id='falseAlarmBtn_{$id}' onclick='toggleFalseAlarm({$id})'>False Alarm</button>
                    <button id='verifyBtn_{$id}' onclick='verifyAlert({$id})'>Verified</button>
                </td>
              </tr>";
    }
}
?>

            </tbody>
        </table>
    </div>
</div>
<script>
    const modal = document.getElementById('alertModal');

    function openModal() {
        modal.style.display = 'flex';
    }

    function closeModal() {
        const buttons = document.querySelectorAll('button');
        buttons.forEach(button => {
            button.classList.remove('clicked'); 
        });


        const statusCells = document.querySelectorAll('[id^="status_"]');
        const smsStatusCells = document.querySelectorAll('[id^="sms_"]');
        const smsReasonCells = document.querySelectorAll('[id^="sms_reason_"]');
        
        statusCells.forEach(cell => cell.innerText = '');
        smsStatusCells.forEach(cell => cell.innerText = '');
        smsReasonCells.forEach(cell => cell.innerText = '');

        modal.style.display = 'none'; 
    }


    function toggleFalseAlarm(id) {
        const falseAlarmButton = document.getElementById('falseAlarmBtn_' + id);
        const verifyButton = document.getElementById('verifyBtn_' + id);  


        if (!falseAlarmButton.classList.contains('clicked')) {
            falseAlarmButton.classList.add('clicked');
            verifyButton.classList.remove('clicked'); 
            updateStatus(id, 'False Alarm', 'No SMS', 'False Alarm'); 
        } else {
            falseAlarmButton.classList.remove('clicked');
            updateStatus(id, '', '', '');
        }
    }

    function updateStatus(id, status, smsStatus, smsReason) {
        const statusCell = document.getElementById('status_' + id);
        const smsStatusCell = document.getElementById('sms_' + id);
        const smsReasonCell = document.getElementById('sms_reason_' + id);

        statusCell.innerText = status;
        smsStatusCell.innerText = smsStatus;
        smsReasonCell.innerText = smsReason;
    }
</script>







</body>
</html>