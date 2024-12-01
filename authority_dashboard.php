<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>LA Dashboard</title>
    <link rel="icon" href="./images/Floodpinglogo.png" type="image/png">
    <link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f9f9f9;
            display: flex;
        }

        .container {
            width: 100%;
            padding: 20px;
        }

        .header {
            background-image: url('./images/bgwaves.jpg');
            background-size: cover;
            border-radius: 8px;
            padding: 20px;
            color: white;
            font-size: 18px;
            font-weight: bold;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            height: 100px;
            
        }

        .header-title {
            font-size: 24px;
        }

        .header-date {
            font-size: 18px;
        }

        .main-content {
            display: flex;
            gap: 20px;
            margin-top: 20px;
        }

        .left-section {
            flex: 3;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .right-section {
            flex: 2;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            right: 60px;
            width: 500px;
            height: 340px;
            gap: 20px;
        }

        .titlee {
            font-size: 18px;
            margin-bottom: 10px;
            padding-bottom: 5px;
            border-bottom: 2px solid #ddd;
            border-radius: 8px;
            background-color: #E8F3F8;
            color: #02476A;
            text-align: center;
        }

        .dashboard-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1;
            text-align: center;
        }

        .card h3 {
            margin: 0;
            font-size: 16px;
        }

        .card-value {
            font-size: 30px;
            font-weight: bold;
            margin: 10px 0;
            color: #4597C0;
        }

        .highlight-moderate {
            color: orange;
            font-weight: bold;
        }

        .station-info {
            text-align: center;
        }

        .station-info img {
            max-width: 100%;
            border-radius: 8px;
            margin-bottom: 10px;
            display: flex;
            text-align: left;
        }

        .info-buttons button {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
            -ms-flex-align: end;
            margin-left: 480px;
        }

        .info-buttons .watch-live {
            background-color: #28a745;
            color: white;
        }

        .info-buttons .view-alerts {
            background-color: #007bff;
            color: white;
        }

        .legend {
            background-color: white;
            border-radius: 8px;
            text-align: center;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
            font-size: 14px;
            color: gray;
        }
    </style>
</head>
<body>
    <?php 
        session_start(); 
        include('./db_conn.php');
        include('./sidebar.php'); 
        date_default_timezone_set('Asia/Manila'); 

        // Initialize total residents
        $totalResidents = 0;

        // Fetch the total number of residents
        $result = $conn->query("SELECT COUNT(*) AS total FROM residents");
        if ($result) {
            $row = $result->fetch_assoc();
            $totalResidents = $row['total'];
        }
    ?>
    <div class="container">
        <div class="header">
            <div class="header-title">FLOODPING: FLOOD MONITORING AND ALERT SYSTEM</div>
            <div class="header-date"><?php echo date('F d, Y h:i A'); ?></div>
        </div>

        <div class="main-content">
            <!-- Left Section -->
            <div class="left-section">
                <div>
                    <div class="titlee">Flood Monitoring</div>
                    <div class="dashboard-row">
                        <div class="card">
                            <div class="card-value highlight-moderate">MODERATE</div>
                            <h3>Water Level</h3>
                        </div>
                        <div class="card">
                            <div class="card-value">10.6 meters</div>
                            <h3>Height</h3>
                        </div>
                        <div class="card">
                            <div style="color:red;" class="card-value">0.02 m/min</div>
                            <h3>Actual Speed Rate</h3>
                        </div>
                        <div class="card">
                            <div class="card-value">0.01 m/hr</div>
                            <h3>Average Speed Rate</h3>
                        </div>
                    </div>
                </div>
                <div>
                    <div class="titlee">Resident Alerts</div>
                    <div class="dashboard-row">
                        <div class="card">
                            <div class="card-value highlight-moderate"><?php echo $totalResidents; ?></div>
                            <h3>Number of Residents</h3>
                        </div>
                        <div class="card">
                            <div class="card-value">2</div>
                            <h3>Issued Flood Alerts</h3>
                        </div>
                        <div class="card">
                            <div class="card-value">0</div>
                            <h3>Credits Available</h3>
                        </div>
                    </div>
                </div>
                <div class="station-info">
                    <img src="./images/darius.png" alt="Darius Creek Station Image">
                    <h3>DARIUS CREEK</h3>
                    <p><strong>Station Location:</strong> Near Santolan Street</p>
                    <div class="info-buttons">
                        <button class="watch-live">WATCH LIVESTREAM</button>
                        <button class="view-alerts">VIEW FLOOD ALERTS</button>
                    </div>
                </div>
            </div>

            <!-- Right Section -->
            <div class="right-section">
                <div class="titlee">Flood Height Point Graph</div>
                <img src="./images/floodgraph.png" alt="Flood Height Graph" style="width: 100%; height: auto;">
                <div class="legend"><b>Legend:</b><br> Normal (9m) • Low (10m) • Moderate (13m) • Critical (15m)</div>
            </div>
        </div>
    </div>
</body>
</html>
