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
        margin-top:50px;
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        width: 100%;
    }

    .header-title {
        font-size: 24px;
        font-weight: bold;
    }

    .header-date {
        font-size: 18px;
        font-weight: normal;
    }

        .dashboard-section {
            margin-top: 50px;
            
        }

        .dashboard-row {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
            margin-top: 20px;
        }

        .card {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            padding: 20px;
            flex: 1 1 calc(25% - 20px);
            text-align: center;
        }

        .card h3 {
            margin: 0;
            font-size: 16px;
            font-weight: normal;
        }

        .card-value {
            font-size: 20px;
            font-weight: bold;
            margin: 10px 0;
        }

        .highlight-moderate {
            color: orange;
            font-weight: bold;
        }

        .info-section {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            margin-top: 20px;
        }

        .info-card {
            flex: 1;
            background-color: white;
            border-radius: 8px;
            padding: 20px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .info-card img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }

        .info-buttons {
            margin-top: 10px;
        }

        .info-buttons button {
            padding: 10px 15px;
            margin: 5px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 14px;
        }

        .info-buttons .watch-live {
            background-color: #28a745;
            color: white;
        }

        .info-buttons .view-alerts {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body>
<?php 
session_start(); 
include('./sidebar.php'); 
date_default_timezone_set('Asia/Manila'); 
?>
   
   <div class="container">
    <div class="header">
        <div class="header-content">
            <div class="header-title">FLOODPING: FLOOD MONITORING AND ALERT SYSTEM</div>
            <div class="header-date"><?php echo date('F d, Y h:i A'); ?></div>
        </div>
    </div>

            <!-- Flood Monitoring Section -->
            <div class="dashboard-section">
            <div class="header1">FLOOD MONITORING</div>
                <div class="dashboard-row">
                    <div class="card">
                        <h3>Water Level</h3>
                        <div class="card-value highlight-moderate">MODERATE</div>
                    </div>
                    <div class="card">
                        <h3>Height</h3>
                        <div class="card-value">10.6 meters</div>
                    </div>
                    <div class="card">
                        <h3>Actual Speed Rate</h3>
                        <div class="card-value">0.02 m/min</div>
                    </div>
                    <div class="card">
                        <h3>Average Speed Rate</h3>
                        <div class="card-value">0.01 m/hr</div>
                    </div>
                </div>
            </div>

            <!-- Resident Alerts Section -->
            <div class="dashboard-section">
                <div class="header1">RESIDENT ALERTS</div>
                <div class="dashboard-row">
                    <div class="card">
                        <h3>Number of Residents</h3>
                        <div class="card-value">10</div>
                    </div>
                    <div class="card">
                        <h3>Issued Flood Alerts</h3>
                        <div class="card-value">2</div>
                    </div>
                    <div class="card">
                        <h3>Credits Available</h3>
                        <div class="card-value">980</div>
                    </div>
                </div>
            </div>

            <!-- Station Info Section -->
            <div class="dashboard-section">
                <div class="info-section">
                    <div class="info-card">
                        <img src="station_image.jpg" alt="Station Image">
                        <h3>DARIUS CREEK</h3>
                        <p>Station Location: Near Santolan Street</p>
                        <div class="info-buttons">
                            <button class="watch-live">WATCH LIVESTREAM</button>
                            <button class="view-alerts">VIEW FLOOD ALERTS</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</body>
</html>
