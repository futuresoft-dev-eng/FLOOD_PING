<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flood Alerts</title>
    <link rel="icon" href="./images/Floodpinglogo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .modal-body {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
        }
        .top-left, .top-right, .bottom {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            background-color: #fff;
        }
        .top-left {
            flex: 2;
            min-width: 300px;
        }
        .top-right {
            flex: 1;
            min-width: 300px;
        }
        .bottom {
            width: 100%;
        }
        .status-moderate {
            color: #ff9800;
            font-weight: bold;
        }
        .info-box {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .info-box div {
            flex: 1;
            text-align: center;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        .info-box div h5 {
            margin: 0;
            font-size: 18px;
        }
        .info-box div span {
            font-size: 12px;
            color: #6c757d;
        }
    </style>
</head>
<body>
<?php
session_start();
include_once('db_conn.php');
include('./sidebar.php');
?>

<div class="container mt-5">
    <button type="button" style="background-color: #59C447;  border: none;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#floodAlertModal">
       REVIEW ALERT
    </button>
</div>

<!-- Modal -->
<div class="modal fade" id="floodAlertModal" tabindex="-1" aria-labelledby="floodAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="floodAlertModalLabel">Flood Alert Management</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Top Left Section -->
                <div class="top-left">
                    <div style="background-color: #e9ecef; height: 200px; margin-bottom: 10px;"></div>
                    <p>Latest Update As Of: <strong>20 October 2024 | 11:01 AM</strong></p>
                    <button class="btn btn-secondary w-100 mb-3">See More Information ></button>
                    <div class="info-box">
                        <div>
                            <h5 class="status-moderate">MODERATE</h5>
                            <span>Water Level</span>
                        </div>
                        <div>
                            <h5>13 meters</h5>
                            <span>Height</span>
                        </div>
                        <div>
                            <h5 style="color: red;">⬆</h5>
                            <span>Flow</span>
                        </div>
                        <div>
                            <h5>0.04 m/min</h5>
                            <span>Actual Speed Rate</span>
                        </div>
                    </div>
                </div>

                <!-- Top Right Section -->
                <div class="top-right">
                <h6>SUMMARY</h6>
                <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Flood Alert ID</th>
                                <th>Flood Alert Status</th>
                                <th>SMS Status</th>
                                <th>SMS Status Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0000062</td>
                                <td>Verified</td>
                                <td>SMS Sent</td>
                                <td>Required</td>
                            </tr>
                            <tr>
                                <td>0000061</td>
                                <td>Verified</td>
                                <td>No SMS</td>
                                <td>Overtaken</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Bottom Section -->
                <div class="bottom">
                    <h6>Verify the Flood Alert(s) Below:</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Flood Alert ID</th>
                                <th>Flood Alert Status</th>
                                <th>SMS Status</th>
                                <th>SMS Status Reason</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0000062</td>
                                <td>Verified</td>
                                <td>SMS Sent</td>
                                <td>Required</td>
                            </tr>
                            <tr>
                                <td>0000061</td>
                                <td>Verified</td>
                                <td>No SMS</td>
                                <td>Overtaken</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger">Cancel</button>
                <button type="button" class="btn btn-success">Confirm</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap Bundle with JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
