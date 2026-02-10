<?php include("check_login.php"); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Matches - Cricket Schedule</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            background-color: #f9f9f9; 
            margin: 0; 
            padding-bottom: 60px; /* space for footer */
        }
        header { 
            background-color: #2c3e50; 
            color: white; 
            text-align: center; 
            padding: 20px; 
        }
        .container { 
            width: 90%; 
            margin: 30px auto; 
            overflow-x: auto; 
        }
        .back-btn {
            background-color: #3498db;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            margin-bottom: 20px;
            transition: background 0.3s;
        }
        .back-btn:hover {
            background-color: #2980b9;
        }
        table { 
            width: 100%; 
            border-collapse: collapse; 
            background-color: white; 
            box-shadow: 0 4px 8px rgba(0,0,0,0.1); 
            border-radius: 8px; 
        }
        th, td { 
            padding: 15px; 
            text-align: center; 
            border: 1px solid #ddd; 
            font-size: 16px; 
        }
        th { 
            background-color: #2c3e50; 
            color: white; 
        }
        .book-now-button { 
            background-color: #2980b9; 
            color: white; 
            padding: 10px 15px; 
            border-radius: 5px; 
            text-decoration: none; 
        }
        .book-now-button:hover { 
            background-color: #3498db; 
        }
        .disabled-button { 
            background-color: #ccc; 
            color: #555; 
            padding: 10px 15px; 
            border-radius: 5px; 
            border: none; 
            cursor: not-allowed; 
        }
        .coming-soon { 
            text-align: center; 
            font-size: 18px; 
            padding: 20px; 
            background-color: #ecf0f1; 
            color: #2c3e50; 
        }
        .next-msg {
            text-align: center;
            font-size: 18px;
            margin-top: 20px;
            color: #2c3e50;
            font-weight: bold;
        }
        footer { 
            background-color: #333; 
            color: white; 
            text-align: center; 
            padding: 12px; 
            position: fixed; 
            bottom: 0; 
            left: 0; 
            width: 100%; 
            font-size: 15px;
        }

        /* Responsive Book Now Button */
        .book-now-button {
            display: inline-block;
            font-size: clamp(14px, 2.2vw, 18px);
            padding: clamp(8px, 1.8vw, 12px) clamp(12px, 2.4vw, 18px);
            border-radius: 6px;
        }

        /* Responsive Disabled Button */
        .disabled-button {
            font-size: clamp(14px, 2.2vw, 18px);
            padding: clamp(8px, 1.8vw, 12px) clamp(12px, 2.4vw, 18px);
            border-radius: 6px;
        }

        /* Make table scroll properly on very small screens */
        @media(max-width: 600px) {
            table {
                font-size: 14px;
            }
            th, td {
                padding: 10px;
            }
        }

    </style>
</head>
<body>

<header>
    <h1>Matches Schedule 2025</h1>
</header>

<div class="container">

    <!-- ✅ Back Button -->
    <button class="back-btn" onclick="window.location.href='home.php'">⬅ Back to Home</button>

    <table>
        <thead>
            <tr>
                <th>Date (YY-MM-DD)</th>
                <th>Time</th>
                <th>Teams</th>
                <th>Venue</th>
                <th>Booking</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $conn = new mysqli("localhost", "root", "", "stadiumd");
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            $sql = "SELECT * FROM matches ORDER BY date ASC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Convert date to YY-MM-DD format
                    $formattedDate = date("y-m-d", strtotime($row['date']));

                    echo "<tr>
                        <td>{$formattedDate}</td>
                        <td>{$row['time']}</td>
                        <td>{$row['teams']}</td>
                        <td>{$row['venue']}</td>";

                    if ($row['booking_status'] == 'active') {
                        echo "<td><a href='seats.php?id={$row['id']}' class='book-now-button'>Book Now</a></td>";
                    } else {
                        echo "<td><button class='disabled-button'>Booking Paused</button></td>";
                    }

                    echo "</tr>";
                }
            } else {
                echo "<tr><td colspan='5' class='coming-soon'>No Matches Available</td></tr>";
            }

            $conn->close();
            ?>
        </tbody>
    </table>

    <!-- New Message After Matches -->
    <div class="next-msg">
        🕒 Upcoming matches will be announced soon!
    </div>
</div>

<footer>
    <p>&copy; 2025 Cricket Schedule. All rights reserved.</p>
</footer>

</body>
</html>
