<?php include("check_login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Contact Us | Online Stadium Ticket Booking</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f0f0;
      overflow-x: hidden;
    }

    /* HEADER */
    header {
      background-color: #2c3e50;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      position: relative;
    }

    /* MENU ICON (TOP-LEFT) */
    .menu-icon {
      position: absolute;
      top: 18px;
      left: 20px;
      font-size: 28px;
      cursor: pointer;
      color: white;
    }

    /* SIDEBAR MENU */
    .sidebar {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      background-color: #2c3e50;
      overflow-x: hidden;
      transition: 0.4s;
      padding-top: 60px;
    }

    .sidebar a {
      display: block;
      color: white;
      padding: 14px 25px;
      text-decoration: none;
      font-size: 18px;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: #27ae60;
    }

    .close-btn {
      position: absolute;
      top: 15px;
      right: 25px;
      font-size: 30px;
      color: white;
      cursor: pointer;
    }

    /* CONTACT PAGE */
    .contact-page {
      max-width: 1200px;
      margin: 50px auto;
      padding: 40px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .contact-page h2 {
      text-align: center;
      font-size: 32px;
      margin-bottom: 30px;
      color: #2c3e50;
    }

    .contact-page p {
      font-size: 16px;
      line-height: 1.6;
      color: #555;
      margin-bottom: 20px;
    }

    .contact-info {
      display: flex;
      justify-content: space-around;
      margin-bottom: 50px;
      flex-wrap: wrap;
    }

    .contact-info .info-item {
      width: 30%;
      text-align: center;
    }

    .contact-info .info-item h3 {
      color: #27ae60;
      font-size: 24px;
      margin-bottom: 10px;
    }

    .contact-info .info-item p {
      font-size: 16px;
      color: #777;
    }

    .contact-form {
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    .contact-form input,
    .contact-form textarea {
      width: 80%;
      padding: 10px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
    }

    .contact-form button {
      background-color: #27ae60;
      color: white;
      padding: 12px 30px;
      font-size: 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 20px;
      transition: background 0.3s;
    }

    .contact-form button:hover {
      background-color: #2ecc71;
    }

    footer {
      background-color: #333;
      color: #fff;
      padding: 20px;
      text-align: center;
      width: 100%;
      margin-top: 30px;
      left: 0;
    }

    footer a {
      color: #fff;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    @media (max-width: 768px) {
      .contact-info {
        flex-direction: column;
        align-items: center;
      }

      .contact-info .info-item {
        margin-bottom: 30px;
        width: 80%;
      }
    }
  </style>
</head>
<body>

  <!-- Sidebar Menu -->
  <div id="sidebarMenu" class="sidebar">
    <span class="close-btn" onclick="closeMenu()">&times;</span>
    <a href="home.php">🏠 Home</a>
    <a href="about.php">ℹ️ About</a>
    <a href="contact.php">📞 Contact</a>
    <a href="matches.php">🎟️ Book Seat</a>
  </div>

  <!-- Header -->
  <header>
    <span class="menu-icon" onclick="openMenu()">☰</span>
    Contact Us - Online Stadium Ticket Booking
  </header>

  <div class="contact-page">
    <h2>Get in Touch with Us</h2>
    <p>
      We would love to hear from you! Whether you have a question about our services, need help with booking tickets, or 
      just want to give us feedback, feel free to reach out.
    </p>
    
    <div class="contact-info">
      <div class="info-item">
        <h3>Our Address</h3>
        <p>Maharashtra (Jalgaon - 425001)</p>
      </div>

      <div class="info-item">
        <h3>Phone Number</h3>
        <p>9022510682</p>
      </div>

      <div class="info-item">
        <h3>Email</h3>
        <p>mahajanmohit005@gmail.com</p>
      </div>
    </div>

    <h3 style="text-align:center;">Send Us a Message</h3>
    <form class="contact-form" action="#" method="POST">
      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
      <button type="submit" name="send">Submit</button>
    </form>
  </div>

  <footer>
    <a href="about.php">About Us</a> |
    <a href="home.php">Home</a>
    <p>&copy; 2025 Online Stadium Ticket Booking.</p>
  </footer>

  <script>
    function openMenu() {
      document.getElementById("sidebarMenu").style.width = "250px";
    }
    function closeMenu() {
      document.getElementById("sidebarMenu").style.width = "0";
    }
  </script>

</body>
</html>

<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if(isset($_POST['send'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $msg = htmlspecialchars($_POST['message']);

    require 'phpmailer/Exception.php';
    require 'phpmailer/PHPMailer.php';
    require 'phpmailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'mahajanmohit005@gmail.com';
        $mail->Password   = 'qiiolrznbiimpbdd';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
        $mail->Port       = 465;

        $mail->setFrom($email, $name);
        $mail->addAddress('mahajanmohit005@gmail.com', 'Admin');

        $mail->isHTML(true);
        $mail->Subject = 'New Contact Form By '.$name;
        $mail->Body    = "<h3>Name: $name</h3><p>Email: $email</p><p>Message: $msg</p>";

        $mail->send();
        echo "<script>alert('Message has been sent successfully!'); window.location.href='contact.php';</script>";
    } 
    catch (Exception $e) {
        echo "<script>alert('Message could not be sent. Please try again later.'); window.history.back();</script>";
    }
}
?>
