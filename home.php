<?php include("check_login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Stadium Ticket Booking</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      background-color: #f0f0f0;
      overflow-x: hidden;
    }

    /* ---------- Sidebar Menu ---------- */
    .menu-icon {
      position: fixed;
      top: 15px;
      left: 20px;
      font-size: 28px;
      color: white;
      background-color: rgba(0, 0, 0, 0.5);
      padding: 8px 12px;
      border-radius: 5px;
      cursor: pointer;
      z-index: 1001;
    }

    .menu-icon:hover {
      background-color: rgba(0, 0, 0, 0.7);
    }

    .sidebar {
      height: 100%;
      width: 0;
      position: fixed;
      z-index: 1000;
      top: 0;
      left: 0;
      background-color: #111;
      overflow-x: hidden;
      transition: 0.4s;
      padding-top: 60px;
    }

    .sidebar a {
      padding: 12px 30px;
      text-decoration: none;
      font-size: 18px;
      color: #f1f1f1;
      display: block;
      transition: 0.3s;
    }

    .sidebar a:hover {
      background-color: #3498db;
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

    /* Slideshow Container */
    .slideshow-container {
      position: relative;
      width: 100%;
      height: 400px;
    }

    .slide {
      display: none;
    }

    .slide img {
      width: 100%;
      height: 400px;
      object-fit: cover;
    }

    /* Slideshow Text and Buttons */
    .slideshow-content {
      position: absolute;
      top: 50%;
      width: 100%;
      text-align: center;
      transform: translateY(-50%);
    }

    .website-name {
      color: white;
      font-size: 2.5vw;
      font-weight: bold;
      background-color: rgba(0, 0, 0, 0.6);
      padding: 10px;
      border-radius: 8px;
      display: inline-block;
    }

    .buttons {
      margin-top: 15px;
    }

    .buttons a {
      text-decoration: none;
      font-size: 1.2vw;
      font-weight: bold;
      background-color: rgba(52, 152, 219, 0.7);
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      display: inline-block;
      margin: 5px;
    }

    .buttons a:hover {
      background-color: rgba(39, 174, 96, 0.7);
    }

    /* Main Content */
    .main-content {
      text-align: center;
      background-color: rgb(225, 231, 235);
      margin: 20px auto;
      box-shadow: 0 10px 10px rgba(0, 0, 0, 0.1);
      max-width: 1200px;
      padding: 30px;
    }

    /* Booking Section */
    .booking-form {
      background-color: rgb(94, 87, 87);
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
      max-width: 900px;
      margin: 0 auto;
      position: relative;
    }

    .booking-form a {
      display: block;
      position: relative;
    }

    .booking-form img {
      width: 100%;
      border-radius: 10px;
    }

    /* Overlay Text on Image */
    .overlay-text {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      text-align: center;
      color: white;
      font-size: 2vw;
      font-weight: bold;
      text-shadow: 2px 2px 5px rgba(0, 0, 0, 0.7);
      background-color: rgba(0, 0, 0, 0.5);
      padding: 10px;
      border-radius: 5px;
      width: 80%;
    }

    /* Image Gallery */
    .gallery {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 30px;
      flex-wrap: wrap;
    }

    .gallery img {
      width: 350px;
      height: 200px;
      object-fit: cover;
      border-radius: 10px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    /* Footer */
    footer {
      background-color: #333;
      color: #fff;
      padding: 20px;
      text-align: center;
      width: 100%;
      margin-top: 30px;
    }

    footer a {
      color: #fff;
      text-decoration: none;
      display: inline-block;
      margin-bottom: 10px;
    }

    footer a:hover {
      text-decoration: underline;
    }

    /* Responsive */
    @media (max-width: 768px) {
      .website-name {
        font-size: 4vw;
      }
      .buttons a {
        font-size: 2vw;
      }
      .overlay-text {
        font-size: 4vw;
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
    <a href="about.php">ℹ️ About Us</a>
    <a href="contact.php">📞 Contact</a>
    <a href="matches.php">🎟️ Book Seat</a>
  </div>

  <!-- Slideshow Section -->
  <div class="slideshow-container">
    <div class="slide fade">
      <img src="img/st3.jpg" alt="Event 1">
    </div>
    <div class="slide fade">
      <img src="img/st4.jpg" alt="Event 2">
    </div>
    <div class="slideshow-content">
      <div class="website-name">Online Stadium Ticket Booking</div>
      <div class="buttons">
        <a href="about.php">About Us</a>
        <a href="contact.php">Contact</a>
        <a href="logout.php">Logout</a>
      </div>
    </div>
  </div>

  <!-- Main Booking Section -->
  <div class="main-content">
    <div class="booking-form">
      <a href="matches.php">
        <img src="img\st12.png" alt="Upcoming Matches"> 

      </a>
    </div>

    <style>
    @keyframes pulseGlow {
      0% { box-shadow: 0 0 10px rgba(255,255,255,0.4); }
      50% { box-shadow: 0 0 25px rgba(255,204,0,0.8); }
      100% { box-shadow: 0 0 10px rgba(255,255,255,0.4); }
    }
    .booking-form:hover .overlay-text {
      background: rgba(255, 204, 0, 0.8);
      color: black;
      transform: translate(-50%, -50%) scale(1.05);
      transition: all 0.3s ease;
      cursor: pointer;
    }
    </style>


    <div class="gallery">
      <img src="img/ipl.jpeg" alt="Game 1">
      <img src="img/wc.jpeg" alt="Game 2">
      <img src="img/t20.jpeg" alt="Game 3">
    </div>
  </div>

  <footer>
    <a href="contact.php">Contact</a><br>
    <a href="about.php">About Us</a><br>
    <p>Sports is a passion<br>So join us to enjoy!</p>
  </footer>

  <script>
    // Slideshow
    let slideIndex = 0;
    function showSlides() {
      let slides = document.getElementsByClassName("slide");
      for (let i = 0; i < slides.length; i++) slides[i].style.display = "none";
      slideIndex++;
      if (slideIndex > slides.length) slideIndex = 1;
      slides[slideIndex - 1].style.display = "block";
      setTimeout(showSlides, 3000);
    }
    showSlides();

    // Sidebar
    function openNav() {
      document.getElementById("mySidebar").style.width = "250px";
    }

    function closeNav() {
      document.getElementById("mySidebar").style.width = "0";
    }
  </script>

</body>
</html>
