<?php
session_start();

// If user not logged in, send back to login page
if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true){
    header("Location: index.php"); // index.php = your login page
    exit();
}
?>
