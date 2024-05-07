<?php
session_start();
if (!isset($_SESSION['usernamein'])) {
    header("Location: signin.php");
    exit;
}

// Database connection parameters
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='learning management sys';

// Establish database connection
$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task'])) {
    // Retrieve task from the form
    $task = $_POST['task'];

    // Sanitize input data
    $task = mysqli_real_escape_string($con, $task);

    // Retrieve username from session variable
    $usernamein = $_SESSION['usernamein'];

    // Prepare SQL statement to delete task from task_schedule table
    $sql = "DELETE FROM task_schedule WHERE username = ? AND task = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $usernamein, $task);

    // Execute the prepared statement
    if ($stmt->execute()) {
        echo "Task deleted successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
} else {
    echo "Invalid request";
}

// Close database connection
mysqli_close($con);
?>
