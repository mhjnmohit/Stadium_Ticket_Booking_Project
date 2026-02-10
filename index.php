<?php
session_start();
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "stadiumd";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

// Prepare alert variables
$alert = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  // LOGIN
  if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
      $_SESSION['username'] = $username;
      $_SESSION['loggedin'] = true;

      // SweetAlert success message
      $alert = "<script>
        Swal.fire({
          icon: 'success',
          title: 'Login Successful!',
          text: 'Redirecting to home...',
          showConfirmButton: false,
          timer: 2000
        }).then(() => {
          window.location.href='home.php';
        });
      </script>";
    } else {
      $alert = "<script>
        Swal.fire({
          icon: 'error',
          title: 'Invalid Username or Password',
          confirmButtonColor: '#ffcc00'
        });
      </script>";
    }
  }

  // SIGNUP
  if (isset($_POST['newUsername']) && isset($_POST['newEmail']) && isset($_POST['newPassword'])) {
    $newUsername = $_POST['newUsername'];
    $newEmail = $_POST['newEmail'];
    $newPassword = $_POST['newPassword'];

    $sql = "INSERT INTO users (username, email, password) VALUES ('$newUsername', '$newEmail', '$newPassword')";
    
    if ($conn->query($sql) === TRUE) {
      $alert = "<script>
        Swal.fire({
          icon: 'success',
          title: 'Signup Successful!',
          text: 'You can now log in.',
          confirmButtonColor: '#ffcc00'
        });
      </script>";
    } else {
      $error = addslashes($conn->error);
      $alert = "<script>
        Swal.fire({
          icon: 'error',
          title: 'Error Occurred',
          text: '$error',
          confirmButtonColor: '#ffcc00'
        });
      </script>";
    }
  }
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login & Signup Page</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <style>
    body {
      font-family: 'Poppins', sans-serif;
      margin: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
      position: relative;
    }

    .slideshow-container {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
    }

    .slideshow-container img {
      position: absolute;
      width: 100%;
      height: 100%;
      object-fit: cover;
      opacity: 0;
      transition: opacity 2s ease-in-out;
    }

    .container {
      background: rgba(0, 0, 0, 0.7);
      color: white;
      width: 400px;
      border-radius: 15px;
      box-shadow: 0 10px 20px rgba(0, 0, 0, 0.3);
      text-align: center;
      padding: 40px;
      position: relative;
      z-index: 10;
    }

    h2 { color: #fff; }

    input {
      width: 90%;
      padding: 10px;
      margin: 15px 0;
      border: 1px solid #ccc;
      border-radius: 5px;
      outline: none;
    }

    button {
      background: #ffcc00;
      color: black;
      padding: 10px 20px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease-in-out;
    }

    button:hover {
      background: #ffdd33;
    }

    .toggle-btns {
      display: flex;
      justify-content: space-around;
      margin-bottom: 30px;
    }

    .toggle-btns button { width: 45%; }
    .hidden { display: none; }

    .admin-btn {
      display: block;
      width: fit-content;
      margin: 20px auto;
      background: #ff5733;
      font-size: 16px;
      padding: 10px 20px;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      text-align: center;
      transition: background 0.3s ease-in-out;
    }

    .admin-btn:hover { background: #e64a19; }

    @media (max-width: 768px) {
      .container { width: 90%; padding: 30px; }
      h2 { font-size: 18px; }
      input { width: 100%; padding: 8px; }
      button { width: 100%; padding: 8px; }
      .toggle-btns { flex-direction: column; }
      .toggle-btns button { width: 100%; margin-bottom: 10px; }
      .admin-btn { width: 80%; }
    }
  </style>
</head>

<body>
<script>
  document.addEventListener('contextmenu', e => e.preventDefault());
  document.addEventListener('keydown', e => {
    if (
      e.key === "F12" ||
      (e.ctrlKey && (e.key === 'u' || e.key === 'U')) ||
      (e.ctrlKey && e.shiftKey && ['I','J','C'].includes(e.key))
    ) e.preventDefault();
  });
  document.ondragstart = () => false;
</script>

<!-- Slideshow -->
<div class="slideshow-container">
  <?php
  $images = ["img/st123.jpg", "img/st2.jpg", "img/st3.jpg"];
  foreach ($images as $index => $image) {
    $opacity = $index === 0 ? "1" : "0";
    echo "<img src='$image' class='slide' style='opacity: $opacity;'>";
  }
  ?>
</div>

<div class="container">
  <h2>Welcome to Online Stadium Ticket Booking</h2>

  <div class="toggle-btns">
    <button onclick="toggleForm('login')">Login</button>
    <button onclick="toggleForm('signup')">Sign Up</button>
  </div>

  <a href="admin/admin.php" class="admin-btn">Admin Login</a>

  <!-- Login -->
  <div id="login" class="form">
    <h3>Login</h3>
    <form method="POST">
      <input type="text" name="username" placeholder="Username" required>
      <input type="password" name="password" placeholder="Password" required>
      <button type="submit">Login</button>
    </form>
  </div>

  <!-- Signup -->
  <div id="signup" class="form hidden">
    <h3>Sign Up</h3>
    <form method="POST">
      <input type="text" name="newUsername" placeholder="Username" required>
      <input type="email" name="newEmail" placeholder="Email" required>
      <input type="password" name="newPassword" placeholder="Password" required>
      <button type="submit">Sign Up</button>
    </form>
  </div>
</div>

<script>
  function toggleForm(form) {
    document.getElementById('login').classList.toggle('hidden', form !== 'login');
    document.getElementById('signup').classList.toggle('hidden', form !== 'signup');
  }

  let slideIndex = 0;
  const slides = document.querySelectorAll('.slide');
  function showSlides() {
    slides.forEach((slide, i) => {
      slide.style.opacity = (i === slideIndex) ? "1" : "0";
    });
    slideIndex = (slideIndex + 1) % slides.length;
    setTimeout(showSlides, 3000);
  }
  showSlides();
</script>

<!-- SweetAlert Output -->
<?php echo $alert; ?>

</body>
</html>
