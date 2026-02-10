<?php include("check_login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About Us | Online Stadium Ticket Booking</title>

  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f8f8f8;
      color: #333;
      overflow-x: hidden;
    }

    /* ===== MENU ICON ===== */
    .menu-icon {
      position: fixed;
      top: 15px;
      left: 20px;
      font-size: 28px;
      color: white;
      background-color: #2c3e50;
      padding: 8px 12px;
      border-radius: 6px;
      cursor: pointer;
      z-index: 1001;
      transition: background 0.3s;
    }

    .menu-icon:hover {
      background-color: rgba(0, 0, 0, 0.7);
    }

    /* ===== SIDEBAR ===== */
    .sidebar {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      background: #2c3e50;
      overflow-x: hidden;
      transition: 0.4s ease;
      padding-top: 60px;
    }

    .sidebar a {
      padding: 14px 30px;
      text-decoration: none;
      font-size: 18px;
      color: #f1f1f1;
      display: block;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: #1abc9c;
      color: #fff;
    }

    .closebtn {
      position: absolute;
      top: 15px;
      right: 25px;
      font-size: 30px;
      color: white;
      cursor: pointer;
    }

    /* ===== HEADER ===== */
    header {
      background-color: #2c3e50;
      color: white;
      padding: 20px;
      text-align: center;
      font-size: 24px;
      position: relative;
    }

    /* ===== ABOUT SECTION ===== */
    .about-us {
      max-width: 1200px;
      margin: 50px auto;
      padding: 40px;
      background-color: #fff;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .about-us h2 {
      text-align: center;
      font-size: 32px;
      margin-bottom: 25px;
      color: #2c3e50;
    }

    .about-us p {
      font-size: 18px;
      line-height: 1.7;
      color: #555;
      margin-bottom: 20px;
      text-align: justify;
    }

    .about-us img {
      width: 100%;
      height: 300px;
      object-fit: cover;
      border-radius: 10px;
      margin-top: 10px;
      margin-bottom: 20px;
    }

    /* ===== TEAM SECTION ===== */
    .about-us .team {
      display: flex;
      justify-content: space-between; /* 🔥 All 5 profiles in one line */
      margin-top: 40px;
      flex-wrap: nowrap;              /* 🔥 No wrapping */
      gap: 20px;
    }

    .about-us .team .team-member {
      text-align: center;
      width: 200px;                   /* 🔥 Fits 5 in one row */
      margin: 0;
    }

    .about-us .team .team-member img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      margin-bottom: 10px;
      transition: transform 0.3s;
    }

    .about-us .team .team-member img:hover {
      transform: scale(1.1);
    }

    .about-us .team .team-member h3 {
      font-size: 20px;
      color: #27ae60;
      margin-bottom: 5px;
      text-align: center;
    }

    .about-us .team .team-member p {
      font-size: 16px;
      color: #777;
      text-align: center;
    }

    /* ===== CONTACT INFO ===== */
    .about-us .contact-info {
      text-align: center;
      margin-top: 50px;
      font-size: 18px;
    }

    .about-us .contact-info a {
      color: #27ae60;
      text-decoration: none;
      font-weight: bold;
    }

    .about-us .contact-info a:hover {
      text-decoration: underline;
    }

    /* ===== FOOTER ===== */
    footer {
      background-color: #333;
      color: #fff;
      padding: 20px;
      text-align: center;
    }

    footer a {
      color: #fff;
      text-decoration: none;
    }

    footer a:hover {
      text-decoration: underline;
    }

    /* ===== RESPONSIVE ===== */
    @media (max-width: 768px) {
      .about-us .team {
        flex-direction: column;
        flex-wrap: wrap;
        justify-content: center;
      }

      .about-us .team .team-member {
        width: 80%;
      }

      .about-us img {
        height: 250px;
      }

      header {
        font-size: 20px;
      }
    }
  </style>
</head>
<body>

  <!-- Menu Icon -->
  <div class="menu-icon" onclick="openNav()">&#9776;</div>

  <!-- Sidebar Menu -->
  <div id="mySidebar" class="sidebar">
    <span class="closebtn" onclick="closeNav()">&times;</span>
    <a href="home.php">🏠 Home</a>
    <a href="about.php">ℹ️ About</a>
    <a href="contact.php">📞 Contact</a>
    <a href="matches.php">🎟️ Book Seat</a>
  </div>

  <!-- Header -->
  <header>
    About Us
  </header>

  <!-- About Section -->
  <div class="about-us">
    <h2>Welcome to Online Stadium Ticket Booking</h2>
    <p>
      At <strong>Online Stadium Ticket Booking</strong>, our mission is to make booking tickets for your favorite sporting events easy, fast, and secure.
      Whether you are an enthusiastic cricket fan or just planning to enjoy a match with friends and family, our platform helps you get your seats with ease.
    </p>

    <p>
      We provide multiple seating options from general admission to VIP experiences, ensuring every fan enjoys the match with comfort.
      Our system offers real-time seat availability and instant confirmation — so you never miss the action!
    </p>

    <img src="img/st123.jpg" alt="Stadium Image">

    <p>
      With a simple interface, secure payment, and 24/7 support, we aim to create a hassle-free experience for all users.
      Our dedicated team continuously works to enhance your experience, ensuring you always feel closer to the game you love.
    </p>

    

    <div class="contact-info">
      <p>Have any questions? Feel free to <a href="contact.php">contact us</a>.</p>
      <p>Stay connected with us through our <a href="#">social media pages</a>!</p>
    </div>
  </div>

  <!-- Footer -->
  <footer>
    <a href="#">Privacy Policy</a> |
    <a href="#">Terms of Service</a> |
    <a href="home.php">Home</a>
    <p>&copy; 2025 Online Stadium Ticket Booking. All rights reserved.</p>
  </footer>

  <script>
    function openNav() {
      document.getElementById("mySidebar").style.width = "250px";
    }
    function closeNav() {
      document.getElementById("mySidebar").style.width = "0";
    }
  </script>

</body>
</html>
