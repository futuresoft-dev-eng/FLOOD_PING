<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; 

$success = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $concern = htmlspecialchars($_POST['concern']);
    $message = htmlspecialchars($_POST['message']);

    $mail = new PHPMailer(true);

    try {
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'floodping.official@gmail.com'; 
        $mail->Password   = 'vijk olie xyap yhhs';   
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        // eender and recipient details
        $mail->setFrom('floodping.official@gmail.com', 'FloodPing Official'); 
        $mail->addAddress('floodping.official@gmail.com', 'FloodPing'); 

        // email content
        $mail->isHTML(true);
        $mail->Subject = "New Contact Form Submission: $concern";
        $mail->Body    = "
          <h3>Contact Form Submission</h3>
          <p><strong>Name:</strong> $name</p>
          <p><strong>Email:</strong> $email</p>
          <p><strong>Concern:</strong> $concern</p>
          <p><strong>Message:</strong><br>$message</p>
        ";
        $mail->AltBody = "Name: $name\nEmail: $email\nConcern: $concern\nMessage: $message";

        $mail->send();
        $success = true;
    } catch (Exception $e) {
        $error_message = "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

if (isset($error_message)): ?>
  <div id="errorModal" class="modal" style="display: flex;">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2>Error</h2>
      <p><?php echo htmlspecialchars($error_message); ?></p>
      <button id="errorOkButton">OK</button>
    </div>
  </div>
  <?php endif;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Floodping</title>
    <link rel="stylesheet" href="about.css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GLhlTQ8iRABdZLl6O3oVMWSktQOp6b7In1Zl3/Jr59b6EGGoI1aFkw7cmDA6j6gD" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=mark_email_read" />
</head>

    <header class="header">
        <nav class="navbar">
        <img class="FPlogo-image" src="images/FloodPingLogo.png" alt="Description of the image">  
            <h2 class="logo">Floodping</h2>
            <ul class="links">
                <li><a href="#landingpage">HOME</a></li>
                <li><a href="livestream.php">LIVESTREAM</a></li>
                <li><a href="about.php" class="active">ABOUT</a></li>
                <li><a href="contact.php">CONTACT</a></li>
            </ul>
            <div class="buttons">
                <a href="login.php" class="signin" onclick="window.location.href='login'">LOG IN</a>
            </div>
        </nav>
    </header>
    
  <body>

    <!-- emergency section -->
    <section class="emergency-section" id="emergency">
        <h2 id='spacingTop'><i class="fas fa-phone-alt"></i>EMERGENCY HOTLINES</h2>
        <div class="container">
            <div class="card-container">
                <div class="card">
                    <div class="imgBx">
                        <img src="https://image.flaticon.com/icons/svg/2092/2092063.svg" alt="">
                    </div>
                    <div class="contentBx">
                      <p>QC EMERGENCY HOTLINE</p>
                      <h2>112</h2>

                      <p>EMERGENCY OPERATIONS CENTER:</p>
                      <h2>0977 031 2892 (GLOBE)</h2>
                      <h2>0947 885 9929 (SMART)</h2>
                      <h2>8988 4242 loc. 7245</h2>

                      <p>EMERGENCY MEDICAL SERVICES / SEARCH AND RESCUE:</p>
                      <h2>0947 884 7498 (SMART)</h2>
                      <h2>8928 4396</h2>
                    </div>
                </div>
                <div class="card">
                    <div class="imgBx">
                        <img src="https://image.flaticon.com/icons/svg/1197/1197460.svg" alt="">
                    </div>
                    <div class="contentBx">
                        <h2></h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
                <div class="card">
                    <div class="imgBx">
                        <img src="https://image.flaticon.com/icons/svg/1067/1067256.svg" alt="">
                    </div>
                    <div class="contentBx">
                        <h2></h2>
                        <p>Lorem ipsum dolor sit amet consectetur adipisicing elit.</p>
                    </div>
                </div>
            </div>
        </div>   
    </section>

    
    <!-- about section -->
  <section class="abt-section" id="about">
    <div class = "photo">
      <img class="imagee" src="" alt="Description of the image">   
    </div>
    
    <div class="about" id="content-about">
      <h2 id='about-title'>ABOUT FLOODPING</h2>
      <p>
        Welcome to FloodPing – your dependable partner in flood preparedness and safety. FloodPing combines cutting-edge sensor technology and real-time water level monitoring to keep communities informed and prepared. When rising water levels reach critical points, our system automatically sends instant alerts to authorized users, empowering local authorities to act fast and minimize risks.
        <br>
        <br>But that’s not all – with FloodPing, local authorities can seamlessly broadcast SMS alerts to residents, reaching them right where they are, no matter the time or place. This ensures everyone stays updated and has the information they need to stay safe. </br>
        <br>
        FloodPing is more than just a tool; it's a commitment to proactive, life-saving action. Join us in building a safer, more resilient community where information flows as swiftly as the alerts we send. Prepare, protect, and trust in FloodPing – where flood management is designed with your safety in mind.
        <br>
        </p>
      </div>
      <br>

<!-- flood awareness section -->
    <div class="floodawareness-section" id="floodawareness-about">
      <div class = "photo">
        <img class="floodawareness-image" src="" alt="Description of the image">
      </div>

      <h2 id='floodawareness-title'>FLOOD AWARENESS</h2>
      <br>
      <p>
        Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</br>
      <br>
      <br>
        Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam quaerat voluptatem.
      </br>
      <br>
        FloodPing is more than just a tool; it's a commitment to proactive, life-saving action. Join us in building a safer, more resilient community where information flows as swiftly as the alerts we send. Prepare, protect, and trust in FloodPing – where flood management is designed with your safety in mind.
      </p>
    </div>
  </div>
<br>

<!-- map section -->
    <div class="map-section" id="map"> 
        <div class = "photo">
          <img class="map-image" src="images/map.jpg" alt="Description of the image">   
    </div> 

    <div class="legend-container">
      <h2>Legends</h2>
      <h2 id='icon'><i class="fas fa-circle icon-red"></i>Fire Prone Area</h2>
      <h2 id='icon'><i class="fas fa-circle icon-blue"></i>Flood Prone Area</h2>
      <h2 id='icon'><i class="fas fa-map-marker-alt" id="loc-icon"></i>Evacuation Area</h2>
  </div>
</div>

<!-- partnership section -->
  <div class="partnership-section" id="partnership">
    <div class = "logo">
      <h2>LINKAGES AND PARTNERSHIP WITH:</h2>
      <img class="brgylogo-image" src="images/brgy-logo.png" alt="Description of the image">   
      <img class="qculogo-image" src="images/QCU-logo.png" alt="Description of the image">
    </div>
  </div>
  <br>
</section>

 
<!-- footer -->
<footer class="footer">
    <div class="footer-container">
        <div class="footer-logo">
            <img src="images/FloodPingLogo.png" alt="FloodPing Logo">
        </div>
        <div class="footer-links">
            <ul>
                <li><a href="privacy-policy.php">Privacy Policy</a></li>
                <li><a href="terms">Terms & Conditions</a></li>
                <li class="faq"><a href="FAQ.php">FAQ</a></li>
            </ul>
        </div>
        <div class="footer-social">
            <p>For news and updates, follow us on:</p>
            <a href="https://www.facebook.com" target="_blank" class="social-icon" style="margin: 0px 0px 0px -380px; position: absolute;">
                <i class="fab fa-facebook-f"></i>
            </a>
            <a href="https://www.instagram.com" target="_blank" class="social-icon">
                <i class="fab fa-instagram"></i>
            </a>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© 2024 Quezon City University</p>
    </div>
</footer>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        // handle success modal
        const successModal = document.getElementById("successModal");
        if (successModal) {
            // close modal when clicking the close icon
            successModal.querySelector(".close").addEventListener("click", () => {
                successModal.style.display = "none";
            });

            // close modal when clicking the OK button
            const okButton = document.getElementById("okButton");
            if (okButton) {
                okButton.addEventListener("click", () => {
                    successModal.style.display = "none";
                });
            }
        }

        // handle error modal
        const errorModal = document.getElementById("errorModal");
        if (errorModal) {
            // Close modal when clicking the close icon
            errorModal.querySelector(".close").addEventListener("click", () => {
                errorModal.style.display = "none";
            });

            // close modal when clicking the OK button in error modal
            const errorOkButton = document.getElementById("errorOkButton");
            if (errorOkButton) {
                errorOkButton.addEventListener("click", () => {
                    errorModal.style.display = "none";
                });
            }
        }
    });

</script>
</body>
</html>