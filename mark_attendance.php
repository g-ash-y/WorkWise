<?php
session_start();
$servername = "localhost"; // Change to your server
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "learning management sys"; // Database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$rollno = $_POST["rollno"];
$attendance_date = $_POST["attendance_date"];
$hour = intval($_POST["hour"]);

// Insert into the attendance table
$sql = "INSERT INTO `attendance` (`rollno`, `attendance`, `date`, `hour`) 
        VALUES ('$rollno', 'A', '$attendance_date', '$hour')";

if ($conn->query($sql) === TRUE) {
    echo "Attendance marked successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
