<?php
session_start();
include 'db_conn.php';
include 'adminsidebar.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: ./HOME/login.php");
    exit();
}

$user_id = $_SESSION['user_id'];


$stmt = $conn->prepare("
    SELECT 
        user_id, first_name, middle_name, last_name, suffix, sex, birthdate, contact_no, 
        email, house_lot_number, street_subdivision_name, barangay, city, role, position, 
        schedule, shift, profile_photo 
    FROM users 
    WHERE user_id = ?
");
if ($stmt) {
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        echo "Error: User not found.";
        exit();
    }
    $stmt->close();
} else {
    echo "Error preparing statement: " . $conn->error;
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Account</title>

</head>
<style>

</style>




<script>
    function toggleEditMode(editMode) {
        const fields = document.querySelectorAll('.editable');
        fields.forEach(field => {
            field.readOnly = !editMode;
            field.style.backgroundColor = editMode ? 'white' : 'gray';
        });

        document.getElementById('editButton').style.display = editMode ? 'none' : 'inline';
        document.getElementById('saveButton').style.display = editMode ? 'inline' : 'none';
    }

    function showModal() {
        if (validateForm()) {
            document.getElementById('confirmModal').style.display = 'block';
        }
    }

    function closeModal() {
        document.getElementById('confirmModal').style.display = 'none';
    }

    function validateForm() {
        let isValid = true;
        const editableFields = document.querySelectorAll('.editable');

      
        document.querySelectorAll('.error-message').forEach(e => e.textContent = '');
        editableFields.forEach(field => field.style.border = '');

       
        editableFields.forEach(field => {
            if (field.value.trim() === "") {
                field.style.border = "2px solid red";
                isValid = false;
            } else {
                field.style.border = "";
            }
        });

   
        const mobileField = document.querySelector("input[name='contact_no']");
        const mobileValue = mobileField.value.trim();
        const mobileError = document.getElementById("contactError");
        const mobileRegex = /^\d{11}$/;

        if (!mobileRegex.test(mobileValue)) {
            mobileField.style.border = "2px solid red";
            mobileError.textContent = "Contact number must be 11 digits and should start with 09.";
            isValid = false;
        } else {
            mobileField.style.border = "";
            mobileError.textContent = "";
        }

  
        const emailField = document.querySelector("input[name='email']");
        const emailValue = emailField.value.trim();
        const emailError = document.getElementById("emailError");
        const emailRegex = /^[a-zA-Z0-9._%+-ñÑ]+@gmail\.com$/;

        if (!emailRegex.test(emailValue)) {
            emailField.style.border = "2px solid red";
            emailError.textContent = "Email must end with @gmail.com";
            isValid = false;
        } else {
            emailField.style.border = "";
            emailError.textContent = "";
        }

        return isValid;
    }


    function enforceNumericInput(event) {
        const keyCode = event.keyCode || event.which;
        const keyValue = String.fromCharCode(keyCode);

        if (!/^\d$/.test(keyValue) && keyCode !== 8 && keyCode !== 46) { 
            event.preventDefault();
        }
    }

  
document.addEventListener('DOMContentLoaded', () => {
    const fields = document.querySelectorAll('.editable');

    fields.forEach(field => {
        field.addEventListener('input', () => {
            field.style.border = ''; 
            const errorElement = field.nextElementSibling;
            if (errorElement && errorElement.classList.contains('error-message')) {
                errorElement.textContent = ''
            }
        });
    });
});


    function checkDuplicates(mobileValue, emailValue) {
        const xhr = new XMLHttpRequest();
        xhr.open('POST', 'check_duplicates.php', true);
        xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                let hasDuplicate = false;

                if (response.duplicateContact) {
                    const mobileField = document.querySelector("input[name='contact_no']");
                    const mobileError = document.getElementById("contactError");
                    mobileField.style.border = "2px solid red";
                    mobileError.textContent = "This contact number is already registered.";
                    hasDuplicate = true;
                }
                if (response.duplicateEmail) {
                    const emailField = document.querySelector("input[name='email']");
                    const emailError = document.getElementById("emailError");
                    emailField.style.border = "2px solid red";
                    emailError.textContent = "This email address is already registered.";
                    hasDuplicate = true;
                }

                if (!hasDuplicate) {
                    document.getElementById('confirmModal').style.display = 'block';
                }
            }
        };
        xhr.send(`contact_no=${mobileValue}&email=${emailValue}`);
    }

    function saveChanges() {
        document.getElementById('editForm').submit();
    }
</script>


<style>

        .container { 
            max-width: 100%; 
            height: 130vh !important;
            margin: 0 0px 0px -120px; 
            padding: 20px;
            font-family: Poppins; 
            background-color: #FFFFFF !important; 
        }
     
        .title-container h3 {
            width: 1220px;
            height: 50px;
            background-color: #4597C0;
            color: #FFFFFF;
            font-size: 20px;
            margin: 100px 0px 0px 70px;
            position: a-zA-Z0-9;
            text-transform: uppercase;
            padding: 10px;
            border-radius: 5px;

        }

        .profile-container { 
            padding: 20px; 
            border-radius: 8px;
            display: flex; 
            flex-direction: row-reverse; 
            gap: 30px; 
        }
        
        .profile-info {
            width: 70%;
            margin: 50px 0px 0px -200px !important;
            position: absolute;
        }

        #createUserForm {
            margin: -35px 0px 0px 850px !important;
            position: absolute;
            width: auto;
            height: auto;
            background-color: transparent;
            font-size: 12px;
        }

        .info-group {
            margin: 0px 0px 0px 300px;
            position: absolute;
            width: 90%;
        }
        .info-item-id  {
            width: 130px;
            margin: 50px 0px 0px 930px;
            position: absolute;
            font-size: 14px;
        }

        .info-item-id input  {
            width: 144px;
            height: 35px;
            border-radius: 5px;
            border: 1px solid #ccc;
            margin: 80px 0px 0px 90px;
            position: absolute;
            font-size: 14px;
        }

        #userID-title {
            width: 100%;
            margin: 140px 0px 0px 120px;
            position: absolute;
            font-size: 15px;
            color: black;
        }


        #address-title {
            position: absolute;
            margin-top: -20px;
        }

        #address {
            margin: 25px 0px 0px -0px;
            width: 100%; 
            padding: 0px; 
        }

        .profile-info h3 {
            margin: 0px 0px 0px 300px;
            font-size: 20px;
            width: auto;

        }

        #position {
            margin: 40px 0px 0px -0px;
        }

        .profile-info hr {
            width: 100%;
        }

        #createUserButton {
            font-size: 18px;
            width: 17%;
            height: 9%;
            padding: 8px auto;
            border-radius: 5px;
            color: #FFFF;
            background-color: #59C447;
            text-transform: uppercase;
            margin: 420px 0px 0px 500px;
            position: absolute;
        }

        #profile_photo {
            display: none;
        }

        #uploadLabel {
            font-size: 14px; 
            color: white; 
            cursor: pointer;
            font-weight: normal;
            margin: -85px 0px 0px 1030px; 
            padding: 50px;
            position: absolute;
            min-width: 1000px !important;
        }   

        #profilePhotoPreview {
            text-align: center; 
            cursor: pointer;
            width: 140px; 
            height: 140px; 
            border: 2px solid #02476A; 
            overflow: hidden; 
            display: inline-block; 
            margin: 60px 0px 0px 1120px;
            position: absolute;
        }

        #upload-icon {
            margin: -40px 0px 0px 1040px;
            position: absolute;
            color: white;
            font-size: 30px;
        }

        .profile-info, .profile-photo { 
            flex: 1; 
            color: #02476A; 
            font-size: 17px; 
        }

        #personal-info-title {
            margin-top: -50px;
            width: 100%;
        }

        .info-group { 
            display: grid; 
            grid-template-columns: repeat(4, 1fr); 
            gap: 40px; 
        }

        .info-item label { 
            font-size: 12px; 
            font-weight: bold; 
            color: black;  
            margin-right: 50px; 
            width: 100%;
        }

        .info-item input, .info-group select {
             width: 100%; 
             padding: 8px; 
             border: 1px solid #02476A; 
             border-radius: 4px; 
             font-size: 12px; 
             position: relative;
        } 
        
        .info-item p {
            font-size: 20px;
        }

        .sex-option {
            display: flex; 
            align-items: center;
            font-size: 14px; 
            color: black; 
            margin: 0px 60px 0px 0px;
           
        }

        .sex-option input[type="radio"] {
            margin: 0px 0px 0px 0px; 
            position: absolute;
           
        }

        #view-activity-btn {
            font-size: 14px;
            width: 17%;
            height: 5%;
            padding: 8px auto;
            border: none;
            border-radius: 5px;
            color: #FFFF;
            background-color: #0073AC;
            text-transform: uppercase;
            margin: 40px 0px 0px 930px;
            position: absolute;
        }

        #editButton {
            font-size: 14px;
            width: 20%;
            height: 8%;
            padding: 10px auto;
            border: none;
            border-radius: 4px;
            color: #FFFF;
            background-color: #084E71;
            text-transform: uppercase;
            margin: -117px 0px 0px 990px;
            position: absolute;
        }

        #saveButton {
            font-size: 14px;
            width: 20%;
            height: 8%;
            padding: 10px auto;
            border: none;
            border-radius: 4px;
            color: #FFFF;
            background-color: #084E71;
            text-transform: uppercase;
            margin: -117px 0px 0px 990px;
            position: absolute;

        }

        #acc-title {
            font-size: 20px;
            font-weight: bold;
            margin: 40px 0px 0px -10px;
            position: absolute;
            text-transform: uppercase;
        }

        #job {
            margin-top: 45px;
            position: relative;
        }

        #brgy {
            margin-top: 25px;
            position: relative;
        }

        input[readonly] {
            background-color: lightgray;
            color: #333;
        }

        .editable {
            background-color: white;
        }

        #confirmModal {
            display: none;
            position: fixed;
            top: 0; left: 0; width: 100%; height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background: #fff; padding: 20px; border-radius: 8px;
            text-align: center; width: 300px; margin: auto;
        }

        .error-message {
            color: red;
            font-size: 0.9em;
        }

        .success-message {
            color: green;;
            margin-top: 20px;
        }

        .error { color: red; font-size: 12px; }
        .error-border { border: 1px solid red; }
        #confirmationModal {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            justify-content: center;
            align-items: center;
        }

        #confirmationModal div {
            background: white;
            padding: 20px;
            border-radius: 5px;
        }
    </style>

</style>

</head>
<body>

<div class="header">
        <p id="acc-title"> My Account </p>
<hr style="color: #ccc; width: 90%; position: absolute; margin: 90px 0px 0px -20px;">
    <button type="button" id="back-button" onclick="window.location.href='add_user.php';"></button>
    <button id="view-activity-btn">VIEW ACTIVITY LOG</button>
    </div>

    <div class="container">
    <div class="title-container">
        <h3>PROFILE</h3>
    </div>

<?php if (isset($_GET['status']) && $_GET['status'] == 'success'): ?>
    <p id="successMessage" class="success-message" style="transition: opacity 0.5s;">
        Profile information has been updated successfully.
    </p>
    <script>
        setTimeout(function () {
            const successMessage = document.getElementById('successMessage');
            successMessage.style.opacity = '0'; 
            setTimeout(function () {
                successMessage.style.display = 'none'; 
            }, 500); 
        }, 2000); 
    </script>
<?php endif; ?>

    
    
   <form id="editForm" method="POST" action="admin_profile_save_changes.php">
    <?php if (!empty($user['profile_photo'])): ?>
        <img id="profilePhotoPreview" src="./uploads/<?= htmlspecialchars($user['profile_photo']) ?>" alt="Profile Photo">
    <?php else: ?>
        <p>No profile photo available.</p>
    <?php endif; ?>
    
    <div class="profile-info">
    <br>
        <div class="info-group">
        <div class="info-item-id">
        <label id="userID-title">Resident ID</label>
    <label>
        <input type="text" value="<?= htmlspecialchars($user['user_id']) ?>" readonly>
    </label><br>
    <br>
    </div>

    <div class="info-item">
    <p id="personal-info-title">Personal Information</p>
    <label>First Name
        <input type="text" value="<?= htmlspecialchars($user['first_name']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item">
    <label>Middle Name 
        <input type="text" value="<?= htmlspecialchars($user['middle_name']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item">
    <label>Last Name 
        <input type="text" value="<?= htmlspecialchars($user['last_name']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item">
    <label>Suffix
        <input type="text" value="<?= htmlspecialchars($user['suffix']) ?>" readonly>
    </label><br>
    </div>
    
    <div class="info-item">
    <label>Sex</label><br>
    <label>
    <input type="radio" name="sex" value="Male" <?= $user['sex'] === 'Male' ? 'checked' : '' ?> disabled 
    style="position: absolute; margin: 3px 0px 0px -470px;"> 
    <span style="margin-left: 30px;">Male</span>
    </label>

    <label>
    <input type="radio" name="sex" value="Female" <?= $user['sex'] === 'Female' ? 'checked' : '' ?> disabled 
    style="position: absolute; margin: -35px 0px 0px -380px;"> 
    <span style="margin: -37px 0px 0px 120px; position: absolute;">Female</span>
</label><br>
</div>

    
    <div class="info-item">
    <label>Birthday 
        <input type="text" value="<?= htmlspecialchars($user['birthdate']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item">  
    <label>Mobile Number 
        <input type="text" class="editable" name="contact_no" onkeypress="enforceNumericInput(event)" pattern="\d{11}" title="11-digit number starting with 09" value="<?= htmlspecialchars($user['contact_no']) ?>" readonly>
        <div id="contactError" class="error-message"></div>
    </label><br>
    </div>
    
    <div class="info-item">
    <label>Email Address
        <input type="email" class="editable" name="email" value="<?= htmlspecialchars($user['email']) ?>" readonly>
        <div id="emailError" class="error-message"></div>
    </label><br>
    </div>

    <div class="info-item">
    <p id="address-title">Address</p>
    <br>
    <label>House/Lot Number
        <input type="text" class="editable" name="house_lot_number" value="<?= htmlspecialchars($user['house_lot_number']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item" id="brgy">
    <label>Street/Subdivision 
        <input type="text" class="editable" name="street_subdivision_name" value="<?= htmlspecialchars($user['street_subdivision_name']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item" id="brgy">
    <label>Barangay <input type="text" value="<?= htmlspecialchars($user['barangay']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item" id="brgy">
    <label>City
        <input type="text" value="<?= htmlspecialchars($user['city']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item">
    <p>Job Description</p>
    <label>Role
        <input type="text" value="<?= htmlspecialchars($user['role']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item" id="job">
    <label>Position: 
        <input type="text" value="<?= htmlspecialchars($user['position']) ?>" readonly>
    </label><br>
    </div>

    <div class="info-item" id="job">
    <label>Schedule
        <input type="text" value="<?= htmlspecialchars($user['schedule'] ?? 'Unassigned') ?>" readonly>
    </label><br>
    </div>

    <div class="info-item" id="job">
    <label>Shift
        <input type="text" value="<?= htmlspecialchars($user['shift'] ?? 'Unassigned') ?>" readonly>
    </label><br>
    </div>

    <button type="button" id="editButton" onclick="toggleEditMode(true)">Edit Information</button>
    <button type="button" id="saveButton" style="display:none;" onclick="showModal()">Save Changes</button>

<div id="confirmModal">
    <div class="modal-content">
        <p>Are you sure you want to save changes?</p>
        <button type="button" onclick="saveChanges()">Yes</button>
        <button type="button" onclick="closeModal()">No</button>
    </div>
</div>

</body>
</html>