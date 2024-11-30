<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Flood Alerts</title>
    <link rel="icon" href="./images/Floodpinglogo.png" type="image/png">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
        }

        .container {
            padding: 20px;
        }

        .modal-body {
            display: flex;
            flex-direction: column;
            gap: 50px;
        }

        .top-section {
            display: flex;
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
        }

        .top-right {
            flex: 1;
        }

        .bottom {
            width: 100%;
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

        .mark-buttons {
            display: flex;
            gap: 10px;
        }

        .mark-buttons button {
            width: 100px;
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
    <button type="button" style="background-color: #59C447; border: none;" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#floodAlertModal">
        REVIEW ALERT
    </button>
</div>

<!-- Modal: Flood Alert Management -->
<div class="modal fade" id="floodAlertModal" tabindex="-1" aria-labelledby="floodAlertModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-fullscreen">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="floodAlertModalLabel">Flood Alert Management</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <!-- Top  -->
                <div class="top-section">
                    <div class="top-left d-flex">
                        <!-- Livestream  -->
                        <div class="livestream flex-grow-1 me-3">
                            <div style="background-color: #e9ecef; height: 200px; margin-bottom: 10px;"></div>
                            <p>Latest Update As Of: <strong>20 October 2024 | 11:01 AM</strong></p>
                        </div>

                        <!-- Info  -->
                        <div class="info-box d-flex flex-column flex-grow-1">
                            <button class="btn btn-secondary w-100 mb-3">See More Information ></button>
                            <div class="d-flex justify-content-between">      
                                <div>
                                    <h5 class="text-warning">MODERATE</h5>
                                    <span>Water Level</span>
                                </div>
                                <div>
                                    <h5>13 meters</h5>
                                    <span>Height</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-between mt-3">
                                <div>
                                    <h5 class="text-danger">⬆</h5>
                                    <span>Flow</span>
                                </div>
                                <div>
                                    <h5>0.04 m/min</h5>
                                    <span>Actual Speed Rate</span>
                                </div>
                            </div>
                        </div>
                    </div>
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
                            </tbody>
                        </table>
                        <div class="modal-footer">
                            <!-- Cancel -->
                            <button type="button" class="btn btn-danger" onclick="window.location.href='floodalerts.php'">Cancel</button>

                            <!-- Confirm -->
                            <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#sendSmsModal" id="confirmButton">Confirm</button>
                        </div>
                    </div>
                </div>
                <!-- Bottom  -->
                <div class="bottom mt-3">
                    <h6>Verify the Flood Alert(s) Below:</h6>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Flood Alert ID</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Water Level</th>
                                <th>Flow</th>
                                <th>Height</th>
                                <th>Flood Alert Status</th>
                                <th>MARK AS</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>0000062</td>
                                <td>20 Oct 2024</td>
                                <td>11:01 AM</td>
                                <td>MODERATE</td>
                                <td>⬆</td>
                                <td>13 meters</td>
                                <td>New</td>
                                <td>
                                    <div class="mark-buttons">
                                        <button class="btn btn-danger btn-sm">False Alert</button>
                                        <button class="btn btn-success btn-sm">Verified</button>
                                    </div>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal: Send SMS -->
<div class="modal fade" id="sendSmsModal" tabindex="-1" aria-labelledby="sendSmsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="sendSmsModalLabel">Send SMS Alert</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p><strong>Send SMS Alert to the registered residents</strong><br>(Magpadala ng mensahe sa mga residente)</p>
                <p>
                    <strong>Flood Alert ID:</strong> 0000062<br>
                    <strong>Flood Alert Status:</strong> Verified<br>
                    <strong>Date (Petsa):</strong> 10/20/2024<br>
                    <strong>Water Level:</strong> Moderate<br>
                    <strong>Height:</strong> 13 meters<br>
                    <strong>Time (Oras):</strong> 11:00:00 AM<br>
                    <strong>Number of Recipients:</strong> 10<br>
                    <strong>Flow:</strong> Rising (Pataas)<br>
                </p>
                <p>
                    <strong>Message Content (Mensahe):</strong><br>
                    FLOODPING (11:00AM, 20Oct24)<br>
                    Darius Creek: Moderate Water Level (13m)<br>
                    Patuloy ang pagtaas ng baha. Nagaganap ang sapilitang pagpapalitas para sa kaligtasan ng lahat. Ang evacuation sites ay sa Bagbag at Goodwill Elem School. Ang lahat ay pinag-iingat.
                </p>
                <button type="button" class="btn btn-success w-100">SEND SMS</button>
            </div>
        </div>
    </div>
</div>

<!-- Include Bootstrap Bundle with JavaScript -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
    const confirmButton = document.getElementById('confirmButton');
    confirmButton.addEventListener('click', () => {
        const floodAlertModal = document.querySelector('#floodAlertModal');
        const modalInstance = bootstrap.Modal.getInstance(floodAlertModal);
        modalInstance.hide();
    });
</script>
</body>
</html>
