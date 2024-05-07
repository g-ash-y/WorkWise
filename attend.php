<?php 
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='learning management sys';


$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
// SQL query to fetch data from the attendance table
$sql = "SELECT rollno, name, attendance, date, time FROM attendance";
$result = $con->query($sql);

if ($result->num_rows > 0) {
    // Output data for each row
    echo "<h2>Attendance Records</h2>";
    echo "<table border='1'>";
    echo "<tr><th>Roll No</th><th>Name</th><th>Attendance</th><th>Date</th><th>Time</th></tr>";
    while ($row = $result->fetch_assoc()) {
        echo "<tr><td>" . $row["rollno"] . "</td><td>" . $row["name"] . "</td><td>" . $row["attendance"] . "</td><td>" . $row["date"] . "</td><td>" . $row["time"] . "</td></tr>";
    }
    echo "</table>";
} else {
    echo "No attendance records found.";
}

// Close the connection
$con->close();
?>

