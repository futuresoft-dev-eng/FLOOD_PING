<?php
include 'db_conn.php';
include 'adminsidebar-accountservices.php';

// Check if user ID is passed for archiving
if (isset($_GET['user_id']) || isset($_POST['user_id'])) {
    $userId = isset($_GET['user_id']) ? trim($_GET['user_id']) : trim($_POST['user_id']);
    echo "Received user_id: " . htmlspecialchars($userId);

    $query = "SELECT * FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);

    if ($stmt === false) {
        die("Error preparing query: " . $conn->error);
    }
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $archiveQuery = "INSERT INTO archive_accounts 
            (user_id, first_name, middle_name, last_name, suffix, contact_no, sex, birthdate, email, city, barangay, house_lot_number, street_subdivision_name, role, position, schedule, shift, profile_photo, archived_at)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        
        $archiveStmt = $conn->prepare($archiveQuery);
        if ($archiveStmt === false) {
            die("Error preparing archive query: " . $conn->error);
        }

        $archiveStmt->bind_param(
            'ssssssssssssssssss',
            $user['user_id'],
            $user['first_name'],
            $user['middle_name'],
            $user['last_name'],
            $user['suffix'],
            $user['contact_no'],
            $user['sex'],
            $user['birthdate'],
            $user['email'],
            $user['city'],
            $user['barangay'],
            $user['house_lot_number'],
            $user['street_subdivision_name'],
            $user['role'],
            $user['position'],
            $user['schedule'],
            $user['shift'],
            $user['profile_photo']
        );

        if ($archiveStmt->execute()) {
            $deleteQuery = "DELETE FROM users WHERE user_id = ?";
            $deleteStmt = $conn->prepare($deleteQuery);
            if ($deleteStmt === false) {
                die("Error preparing delete query: " . $conn->error);
            }

            $deleteStmt->bind_param('s', $userId);
            $deleteStmt->execute();

            if ($deleteStmt->affected_rows > 0) {
                // Instead of header redirection, set a success flag for the modal
                $_SESSION['archive_success'] = "Account archived successfully.";
            } else {
                echo "Failed to delete the user from the users table.";
            }
        } else {
            echo "Failed to archive the user.";
        }

        $archiveStmt->close();
        $deleteStmt->close();

    } else {
        echo "User not found.";
    }
    $stmt->close();

} else {
    // This is where we would echo the message in case of success without redirect
    $_SESSION['archive_success'] = "Account archived successfully.";
}
?>

<!-- Begin HTML for archived accounts display -->

<title>Archive Account Management</title>
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<link href="https://fonts.googleapis.com/icon?family=Material+Symbols+Rounded" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">



<main class="main-content">
<div class="title">
        <h3>USER MANAGEMENT</h3>
    </div>
    <hr style="color: gray; width: 90%; position: absolute; margin: 90px 0px 0px -360px;">

    <div class="buttons-container">
    <button class="navigation-btn" id="userAccountsBtn" onclick="activateButton('userAccountsBtn', 'add_user.php')">User Accounts</button>
    <button class="navigation-btn" id="residentsBtn" onclick="activateButton('residentsBtn', 'residents_list.php')">Resident List</button>
    <button class="navigation-btn active" id="archiveBtn" onclick="activateButton('residentsBtn', 'archive_account.php')">Archive</button>
</div>

<div class="table-container">
    <table id="residentTable" class="table table-bordered">
        <!-- Search Bar -->
        <div class="search-container" style="position: relative; width: 100%; max-width: 300px;">
            <input type="text" id="searchBar" placeholder="Search..." onkeyup="filterTable()" style="padding-left: 30px; width: 100%; padding-right: 20px;">
            <i class="fas fa-search" style="position: absolute; left: 10px; top: 50%; transform: translateY(-50%);"></i>
        </div>

        <!-- Role Filter -->
        <select id="roleFilter" onchange="filterTable()">
            <option value="">Filter by Role</option>
            <option value="Admin">Admin</option>
            <option value="Local Authority">Local Authority</option>
        </select>

        <thead>
            <tr>
                <th>User ID</th>
                <th>First Name</th>
                <th>Middle Name</th>
                <th>Last Name</th>
                <th>Suffix</th>        
                <th>Role</th>
                <th>Position</th>
                <th>Schedule</th>
                <th>Shift</th>  
                <th>Action</th>         
            </tr>
        </thead>
        <tbody>
            <?php
            // Display archived accounts
            $query = "SELECT * FROM archive_accounts ORDER BY archived_at DESC";
            $result = $conn->query($query);

            if ($result->num_rows > 0) {
                // Display each archived account
                while ($row = $result->fetch_assoc()) {
                    echo "<tr data-role='" . htmlspecialchars($row['role']) . "'>
                            <td>" . htmlspecialchars($row['user_id']) . "</td>
                            <td>" . htmlspecialchars($row['first_name']) . "</td>
                            <td>" . htmlspecialchars($row['middle_name']) . "</td>
                            <td>" . htmlspecialchars($row['last_name']) . "</td>
                            <td>" . htmlspecialchars($row['suffix']) . "</td>       
                            <td>" . htmlspecialchars($row['role']) . "</td>
                            <td>" . htmlspecialchars($row['position']) . "</td>
                            <td>" . htmlspecialchars($row['schedule']) . "</td>
                            <td>" . htmlspecialchars($row['shift']) . "</td>
                            <td>
                    <a href='archive_profile.php?user_id=" . htmlspecialchars($row['user_id']) . "' id='view-btn-" . htmlspecialchars($row['user_id']) . "'>
                        <i class='fas fa-eye'></i> VIEW
                    </a>
                </td>

                        </tr>";
                }
            } else {
                echo "<tr><td colspan='9' style='text-align:center;'>No archived accounts found</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
        </main>
<?php $conn->close(); ?>

<style>
    body {
        width: 1000px;
        background-color: white;
    }

    .main-content {
        max-width: 1000px;
        margin-left: 0px; 
        padding: 20px;
        background-color: white;
        overflow: hidden;
    }
        
    .title h3 {
        font-size: 25px;
        font-weight: bold;
        color: #02476A;
        margin: 30px 0px 0px -220px !important; 
        z-index: 100;  
        position: absolute;
    }

    .table-container {
        background-color: white;
        padding: 20px;
        border-radius: 5px;
        border: 1px solid #ccc;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        margin-left: -225px;
        margin-top: 168px;
        position: absolute;
        width: 79.9%;
        height: auto;
        overflow-y: auto; 
    }

    .table th {
        color: #02476A;
        background-color: #E8F3F8;
        font-weight: bold;
        font-size: 13px;
    }

    .table td {
        font-size: 13px;
    }

    .table tbody td:last-child {
        text-align: center;
        display: flex;
        justify-content: center;
    }

    #residentTable {
        width: 100%;
        margin-top: 60px;
        margin-left: 0px;
    }

    #searchBar {
        width: 30%;
        border-radius: 5px;
        border: 1px solid #02476A;
        padding: 8px 12px;
        font-size: 14px;
        margin-top: 0px;
        margin-left: 1020px;
        position: absolute;
    }

    #searchBar + i {
        position: absolute;
        margin-top: 19px;
        margin-left: 1020px;
        transform: translateY(-50%);
        color: #aaa;
        font-size: 16px;
    }

    #roleFilter {
        padding: 8px 12px;
        font-size: 14px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #fff;
        color: #02476A;
        cursor: pointer;
        transition: border-color 0.3s ease;
        width: 19%;
        margin-top: 0px;
        margin-left: 0px;
        position: absolute;
    }

    #roleFilter option {
        padding: 10px;
    }

    .buttons-container {
        display: flex;
        margin: 20px 0;
        position: absolute;
        margin-top: 120px !important;
        margin-left: -225px !important;
        border-radius: none !important;
        z-index: 100;
    }

    .navigation-btn {
        min-width: 455px;
        height: 50px;
        background-color: #FFFFFF;
        color: #02476A;
        border: 1px solid #ccc;
        border-radius: none !important;
        border-top-left-radius: 0px;
        border-bottom-left-radius: 0px;
        border-top-right-radius: 0px;
        border-bottom-right-radius: 0px;
        font-size: 16px;
        text-transform: uppercase;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .navigation-btn.active {
        background-color: #4597C0 !important; 
        color: white !important;
    }


    #userAccountsBtn {
        border-top-left-radius: 10px;
        
    }

    #residentsBtn {
        background-color: #FFFFFF;
        color: #02476A;
        border: 1px solid #ccc;
    }

    #archiveBtn {
        border-top-right-radius: 10px; 
        background-color: #FFFFFF;
        color: #02476A;
        border: 1px solid #ccc;
    }

    a[id^="view-btn-"] { 
        background-color: #4597C0;
        padding: 5px 15px;
        text-transform: uppercase;
        text-decoration: none;
        color: white;
        border-radius: 5px;
        padding: 5px;
        width: 100%;
    }

    a#view-btn-<?= htmlspecialchars($row['user_id']) ?> i.fas.fa-eye { 
        font-size: 18px;  
    }
</style>

<script>
    let originalRows = [];

    window.onload = function() {
        // Store the rows when the page loads
        originalRows = Array.from(document.querySelectorAll("#residentTable tbody tr"));
    };

    function filterTable() {
        let searchValue = document.getElementById('searchBar').value.toLowerCase();
        let roleFilter = document.getElementById('roleFilter').value.toLowerCase();

        // Filter the rows based on search and role filter
        let filteredRows = originalRows.filter(row => {
            let userId = row.children[0].textContent.toLowerCase();
            let firstName = row.children[1].textContent.toLowerCase();
            let lastName = row.children[3].textContent.toLowerCase();
            let role = row.getAttribute('data-role').toLowerCase(); // Use the data-role attribute for role filtering

            return (userId.includes(searchValue) || firstName.includes(searchValue) || lastName.includes(searchValue)) &&
                   (roleFilter === '' || role.includes(roleFilter));
        });

        let tableBody = document.querySelector("#residentTable tbody");
        tableBody.innerHTML = '';  // Clear the current table body

        if (filteredRows.length === 0) {
            tableBody.innerHTML = "<tr><td colspan='9' style='text-align:center;'>No matching records found</td></tr>";
        } else {
            filteredRows.forEach(row => tableBody.appendChild(row));
        }
    }
</script>

<script>
function activateButton(buttonId, redirectUrl) {
        // Remove the active class from all buttons
        const buttons = document.querySelectorAll('.navigation-btn');
        buttons.forEach((btn) => {
            btn.classList.remove('active');
        });

        // Add the active class to the clicked button
        const activeButton = document.getElementById(buttonId);
        activeButton.classList.add('active');

        // Redirect to the provided URL
        if (redirectUrl) {
            window.location.href = redirectUrl;
        }
    }
</script>
