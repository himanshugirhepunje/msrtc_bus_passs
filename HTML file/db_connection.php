<?php
$servername = "localhost";  // Change this if needed
$username = "root";         // Change this to your MySQL username
$password = "";             // Change this to your MySQL password
$dbname = "bus_pass_system";  // Change this to your database name

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    // echo "✅ Database connected successfully!";
}
?>
