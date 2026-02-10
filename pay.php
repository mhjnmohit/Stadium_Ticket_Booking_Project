<?php
include("check_login.php");
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

// Initialize variables
$paymentStatus = false;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['name'], $_POST['selectedSeats'])) {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $event = htmlspecialchars($_POST['event']);
    $selectedSeats = htmlspecialchars($_POST['selectedSeats']);
    $totalPrice = (int) filter_var($_POST['totalPrice'], FILTER_SANITIZE_NUMBER_INT);
}

// Handle payment submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['payment_method'], $_POST['card_holder_name'])) {
    $paymentMethod = htmlspecialchars($_POST['payment_method']);
    $cardHolderName = htmlspecialchars($_POST['card_holder_name']);
    $paymentStatus = true;

    // Insert booking after payment success
    $stmt = $pdo->prepare("INSERT INTO booked (name,email,phone,event,seats,totalPrice,paymentMethod,cardHolder) 
                           VALUES (:name,:email,:phone,:event,:seats,:totalPrice,:paymentMethod,:cardHolder)");
    $stmt->execute([
        ':name'=>$name,
        ':email'=>$email,
        ':phone'=>$phone,
        ':event'=>$event,
        ':seats'=>$selectedSeats,
        ':totalPrice'=>$totalPrice,
        ':paymentMethod'=>$paymentMethod,
        ':cardHolder'=>$cardHolderName
    ]);

    // Update booked seats in session
    foreach($_SESSION['selected'] as $key=>$seat){
        $stand = $seat['stand'];
        $row = $seat['row'];
        $col = $seat['col'];
        $_SESSION['seats'][$stand][$row][$col]['status'] = 'booked';
    }

    // Clear selected seats
    $_SESSION['selected'] = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Payment Confirmation</title>
<style>
body { font-family: Arial; background: #e1e7eb; margin:0; padding:20px; }
.container { max-width:800px; margin:auto; background:white; padding:20px; border-radius:10px; box-shadow:0 4px 8px rgba(0,0,0,0.1);}
h1{text-align:center;color:#27ae60;}
table{width:100%; border-collapse:collapse; margin-bottom:30px;}
table th, table td{padding:12px; text-align:left; border-bottom:1px solid #ddd;}
table th{background-color:#2c3e50; color:white;}
.button-group{text-align:center;}
.button-group button{background-color:#27ae60;color:white;padding:12px 30px;border:none;border-radius:5px;cursor:pointer;margin:10px;}
.button-group button:hover{background-color:#2ecc71;}
.payment-form{display:none;margin-top:20px;text-align:center;}
.payment-form input{padding:10px;margin:10px;width:300px;border-radius:5px;border:1px solid #ddd;}
.payment-form button{background-color:#e74c3c;color:white;padding:8px 20px;font-size:14px;border:none;border-radius:5px;cursor:pointer;margin-bottom:10px;}
.payment-form button:hover{background-color:#c0392b;}
.progress-bar{width:100%;background:#f3f3f3;border-radius:10px;margin-top:10px;}
.progress-bar-inner{height:10px;width:0;background:#27ae60;border-radius:10px;}
.status-message{text-align:center;margin-top:10px;display:none;color:green;font-weight:bold;}
</style>
</head>
<body>
<div class="container">
<h1>Booking Receipt</h1>
<?php if($paymentStatus): ?>
<h3 style="color:green;text-align:center;">✅ Payment Successful</h3>
<p style="text-align:center;">Method: <?= $paymentMethod ?> | Holder: <?= $cardHolderName ?></p>
<table>
<tr><th>Name</th><td><?= $name ?></td></tr>
<tr><th>Email</th><td><?= $email ?></td></tr>
<tr><th>Phone</th><td><?= $phone ?></td></tr>
<tr><th>Event</th><td><?= $event ?></td></tr>
<tr><th>Seats</th><td><?= $selectedSeats ?></td></tr>
<tr><th>Total Price</th><td>₹<?= $totalPrice ?></td></tr>
</table>
<div class="button-group">
<button onclick="window.print()">Print Receipt</button>
<!-- New button to book more seats -->
<button onclick="window.location.href='seats.php'">Book Another Seats</button>
</div>
<?php else: ?>

<div style="text-align:center; margin-top:20px;">
    <button type="button" onclick="window.location.href='seats.php'" 
        style="background:#3498db;color:white;padding:10px 20px;
               border:none;border-radius:8px;margin:10px;cursor:pointer;
               font-weight:bold;transition:0.3s;">
        ⬅ Back to Seats Selection
    </button>

    <button type="button" onclick="showPaymentForm()" 
        style="background:#2ecc71;color:white;padding:10px 20px;
               border:none;border-radius:8px;margin:10px;cursor:pointer;
               font-weight:bold;transition:0.3s;">
        Proceed to Payment ➡
    </button>
</div>

<div class="payment-form" id="payment-form">
<h3>Payment Details</h3>

<form method="POST" onsubmit="startPaymentProcess(event)">
<input type="hidden" name="name" value="<?= $name ?>">
<input type="hidden" name="email" value="<?= $email ?>">
<input type="hidden" name="phone" value="<?= $phone ?>">
<input type="hidden" name="event" value="<?= $event ?>">
<input type="hidden" name="selectedSeats" value="<?= $selectedSeats ?>">
<input type="hidden" name="totalPrice" value="<?= $totalPrice ?>">
<input type="text" name="payment_method" placeholder="Enter UPI ID (e.g. name@upi)" required><br>
<input type="text" name="card_holder_name" placeholder="Enter Holder Name" required><br>
<button type="submit">Submit Payment</button>
</form>
</div>
<div class="progress-bar" id="progress-bar"><div class="progress-bar-inner" id="progress-bar-inner"></div></div>
<div class="status-message" id="status-message">Payment Completed Successfully!</div>
<?php endif; ?>
</div>
<script>
function showPaymentForm(){ document.getElementById("payment-form").style.display="block"; }
function startPaymentProcess(event){
event.preventDefault();
let upiInput = document.querySelector("input[name='payment_method']").value;
let upiPattern = /^[a-zA-Z0-9.\-_]+@[a-zA-Z]+$/;
if(!upiPattern.test(upiInput)){ alert("Invalid UPI ID!"); return; }
document.getElementById("progress-bar").style.display="block";
let progress=0;
let interval = setInterval(function(){
progress+=10; document.getElementById("progress-bar-inner").style.width=progress+"%";
if(progress===100){ clearInterval(interval); document.getElementById("status-message").style.display="block";
setTimeout(()=>event.target.submit(),1000); }
},300);
}
</script>
</body>
</html>
