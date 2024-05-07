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

// Fetch attendance data
$sql = "SELECT * FROM `attendance`";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table>";
    echo "<tr><th>Roll Number</th><th>Student Name</th><th>Attendance</th><th>Date</th><th>Hour</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>{$row['rollno']}</td>
                <td>{$row['name']}</td>
                <td>{$row['attendance']}</td>
                <td>{$row['date']}</td>
                <td>{$row['hour']}</td>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No attendance records found.";
}

$conn->close();
?>