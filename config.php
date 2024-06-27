<?php
$servername = "localhost"; // Replace with your server name if different
$username = "root"; // Replace with your MySQL username
$password = "@1920babu"; // Replace with your MySQL password
$dbname = "payroll_system"; // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>




