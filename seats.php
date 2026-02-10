<?php
include("check_login.php");

// Make sure session is started (in case it's not started in check_login.php)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database connection
$host = 'localhost';
$dbname = 'stadiumd';
$username = 'root';
$password = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database Connection Failed: " . $e->getMessage());
}

// RESET session (clear selected seats)
if (isset($_GET['reset'])) {
    unset($_SESSION['seats'], $_SESSION['selected']);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

/*
 * ✅ Always (re)initialize the seats array so that
 * every seat has 'status', 'type' and 'seatNum' keys.
 */
$stands = ['A', 'B', 'C', 'D'];
$_SESSION['seats'] = []; // fresh structure every time

foreach ($stands as $stand) {
    $seatNumber = 1;
    for ($row = 1; $row <= 10; $row++) {
        for ($col = 1; $col <= 10; $col++) {
            $type = ($seatNumber <= 20) ? 'VIP' : 'Regular';
            $_SESSION['seats'][$stand][$row][$col] = [
                'status'  => 'available',
                'type'    => $type,
                'seatNum' => $seatNumber
            ];
            $seatNumber++;
        }
    }
}

// Load booked seats from database and mark them as booked
$stmt = $pdo->query("SELECT seats FROM booked");
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $bookedSeats = explode(', ', $row['seats']);
    foreach ($bookedSeats as $seatStr) {
        if (preg_match('/([A-D])(\d+)/', $seatStr, $matches)) {
            $stand = $matches[1];
            $seatNum = (int)$matches[2];

            if (!isset($_SESSION['seats'][$stand])) {
                continue; // safety check
            }

            foreach ($_SESSION['seats'][$stand] as $r => $cols) {
                foreach ($cols as $c => $seat) {
                    if (isset($seat['seatNum']) && $seat['seatNum'] == $seatNum) {
                        $_SESSION['seats'][$stand][$r][$c]['status'] = 'booked';
                    }
                }
            }
        }
    }
}

// Initialize selected seats array
if (!isset($_SESSION['selected'])) {
    $_SESSION['selected'] = [];
}

// Handle seat selection toggle
if (isset($_POST['toggle'], $_POST['stand'], $_POST['row'], $_POST['col'])) {
    $stand = $_POST['stand'];
    $row   = intval($_POST['row']);
    $col   = intval($_POST['col']);
    $key   = $stand . '-' . $row . '-' . $col;

    if (isset($_SESSION['seats'][$stand][$row][$col])) {
        $seat = $_SESSION['seats'][$stand][$row][$col];

        if (isset($seat['status']) && $seat['status'] === 'available') {
            // Toggle selected
            if (isset($_SESSION['selected'][$key])) {
                unset($_SESSION['selected'][$key]);
            } else {
                $_SESSION['selected'][$key] = $seat;
                $_SESSION['selected'][$key]['stand'] = $stand;
                $_SESSION['selected'][$key]['row']   = $row;
                $_SESSION['selected'][$key]['col']   = $col;
            }
        }
    }
}

// Calculate total price
$totalPrice = 0;
foreach ($_SESSION['selected'] as $seat) {
    $totalPrice += ($seat['type'] == 'VIP') ? 1000 : 500;
}

// Get selected seats string like A1, A2, B15, ...
$selectedSeatsStr = implode(', ', array_map(function ($s) {
    return $s['stand'] . $s['seatNum'];
}, $_SESSION['selected']));
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Stadium Booking & Ticket Form</title>
<style>
body { font-family: Arial; margin:0; background:#f5f6fa; }
h1, h2 { text-align:center; color:#2c3e50; }
.stand { margin: 20px; display:inline-block; vertical-align: top; text-align:center; }
.row { margin-bottom:5px; }
.seat {
    width:35px;
    height:35px;
    margin:2px;
    display:inline-block;
    line-height:35px;
    color:white;
    text-align:center;
    cursor:pointer;
    border-radius:4px;
    border:none;
}
.seat:hover { transform: scale(1.1); }
.available.vip { background: gold; }
.available.regular { background: green; }
.booked.vip { background: darkorange; cursor:not-allowed; }
.booked.regular { background: red; cursor:not-allowed; }
.selected { border:3px solid blue; }
.legend { margin:20px; text-align:center; }
.legend span { display:inline-block; width:100px; height:20px; margin:2px; }
input[readonly] { background:#f0f0f0; border:1px solid #ccc; padding:5px; width:200px; }
.booking-container {
    background: white;
    max-width: 500px;
    margin: 40px auto;
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0px 8px 16px rgba(0, 0, 0, 0.2);
}
.form-group { margin-bottom: 15px; }
label { font-weight: bold; color: #2c3e50; display:block; margin-bottom:5px; }
input, select {
    width: 100%;
    padding: 12px;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 16px;
}
button {
    background: #27ae60;
    color: white;
    width: 100%;
    padding: 14px;
    border: none;
    border-radius: 6px;
    font-size: 18px;
    cursor: pointer;
    transition: 0.3s;
}
button:hover { background: #2ecc71; }
.error-message { color:red; font-size:13px; display:none; }
a { text-decoration:none; color:blue; }
a:hover { text-decoration:underline; }

/* ✅ Back Button */
.back-btn {
    background-color: #3498db;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 6px;
    font-size: 16px;
    margin: 20px auto;
    display: block;
    cursor: pointer;
    transition: background 0.3s;
}
.back-btn:hover {
    background-color: #2980b9;
}
</style>
</head>
<body>

<h1>Stadium Seat Booking</h1>

<!-- ✅ Back Button -->
<button class="back-btn" onclick="window.location.href='matches.php'">⬅ Back to Matches</button>

<div class="legend">
    <span style="background:gold;"></span> VIP (₹1000)
    <span style="background:green;"></span> Regular (₹500)
    <span style="background:darkorange;"></span> VIP Booked
    <span style="background:red;"></span> Regular Booked
    <span style="border:3px solid blue;"></span> Selected
</div>

<div style="text-align:center;">
<?php foreach ($_SESSION['seats'] as $stand => $rows): ?>
    <div class="stand">
        <h2>Stand <?= htmlspecialchars($stand) ?></h2>
        <?php foreach ($rows as $rowNum => $cols): ?>
            <div class="row">
            <?php foreach ($cols as $colNum => $seatInfo):

                // Extra safety: ensure keys exist
                if (!is_array($seatInfo) ||
                    !isset($seatInfo['status'], $seatInfo['type'], $seatInfo['seatNum'])) {
                    continue;
                }

                $status     = $seatInfo['status'];
                $type       = strtolower($seatInfo['type']);
                $seatNumber = $seatInfo['seatNum'];
                $key        = $stand . '-' . $rowNum . '-' . $colNum;
                $selectedClass = isset($_SESSION['selected'][$key]) ? 'selected' : '';
            ?>
                <form method="post" style="display:inline;">
                    <input type="hidden" name="stand" value="<?= htmlspecialchars($stand) ?>">
                    <input type="hidden" name="row" value="<?= htmlspecialchars($rowNum) ?>">
                    <input type="hidden" name="col" value="<?= htmlspecialchars($colNum) ?>">
                    <button type="submit"
                            name="toggle"
                            value="1"
                            class="seat <?= htmlspecialchars($status) ?> <?= htmlspecialchars($type) ?> <?= $selectedClass ?>"
                            <?= $status == 'booked' ? 'disabled' : '' ?>>
                        <?= htmlspecialchars($seatNumber) ?>
                    </button>
                </form>
            <?php endforeach; ?>
            </div>
        <?php endforeach; ?>
    </div>
<?php endforeach; ?>
</div>

<div class="booking-container">
    <h2>Enter Booking Details</h2>
    <form id="bookingForm" action="pay.php" method="POST" onsubmit="return validateForm()">
        <div class="form-group">
            <label>Full Name</label>
            <input type="text" id="name" name="name" placeholder="Enter your full name" required>
            <p class="error-message" id="nameError">Name must be at least 3 characters long.</p>
        </div>
        <div class="form-group">
            <label>Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            <p class="error-message" id="emailError">Enter a valid email address.</p>
        </div>
        <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter your phone number" required>
            <p class="error-message" id="phoneError">Phone number must be 10 digits.</p>
        </div>
        <div class="form-group">
            <label>Event</label>
            <select id="event" name="event" required>
                <option value="">Select Event</option>
                <option value="Indian Premier League">Indian Premier League</option>
                <option value="International Cricket Matches">International Cricket Matches</option>
                <option value="Domestic Cricket Matches">Domestic Cricket Matches</option>
            </select>
            <p class="error-message" id="eventError">Please select an event.</p>
        </div>
        <div class="form-group">
            <label>Selected Seats</label>
            <input type="text" id="selectedSeats" name="selectedSeats"
                   value="<?= htmlspecialchars($selectedSeatsStr) ?>" readonly>
            <p class="error-message" id="seatError" <?= empty($selectedSeatsStr) ? 'style="display:block;"' : '' ?>>
                Please select at least one seat.
            </p>
        </div>
        <div class="form-group">
            <label>Total Price</label>
            <input type="text" id="totalPrice" name="totalPrice" value="₹<?= htmlspecialchars($totalPrice) ?>" readonly>
        </div>
        <button type="submit" <?= empty($_SESSION['selected']) ? 'disabled' : '' ?>>Confirm & Pay</button>
    </form>
    <p style="text-align:center;margin-top:10px;"><a href="?reset=1">Cancel All Seats</a></p>
</div>

<script>
function validateForm(){
    let valid = true;
    document.querySelectorAll(".error-message").forEach(e => e.style.display = 'none');

    const name  = document.getElementById("name").value.trim();
    const email = document.getElementById("email").value.trim();
    const phone = document.getElementById("phone").value.trim();
    const event = document.getElementById("event").value.trim();
    const seats = document.getElementById("selectedSeats").value.trim();

    if (name.length < 3) {
        document.getElementById("nameError").style.display = 'block';
        valid = false;
    }
    if (!email.match(/^[^ ]+@[^ ]+\.[a-z]{2,}$/)) {
        document.getElementById("emailError").style.display = 'block';
        valid = false;
    }
    if (!phone.match(/^[0-9]{10}$/)) {
        document.getElementById("phoneError").style.display = 'block';
        valid = false;
    }
    if (event === "") {
        document.getElementById("eventError").style.display = 'block';
        valid = false;
    }
    if (seats === "") {
        document.getElementById("seatError").style.display = 'block';
        valid = false;
    }
    return valid;
}
</script>
</body>
</html>
