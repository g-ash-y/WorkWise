<?php
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
$name = $_POST["name"];
$attendance = $_POST["attendance"];
$date = date("Y-m-d"); // Current date
$hour = intval($_POST["hour"]);

// Insert into the attendance table
$sql = "INSERT INTO `attendance` (`rollno`, `name`, `attendance`, `date`, `hour`) 
        VALUES ('$rollno', '$name', '$attendance', '$date', '$hour')";

if ($conn->query($sql) === TRUE) {
    echo "Attendance marked successfully!";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
