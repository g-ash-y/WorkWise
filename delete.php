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

$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

$username = $_SESSION['usernamein']; 

if(isset($_GET['file'])) {
    $file_name = $_GET['file'];
    
    // Assuming `image` column stores file names in the `note_sharing` table
    $delete_query = "DELETE FROM `note_sharing` WHERE `username` = '$username' AND `image` = '$file_name'";
    $delete_result = mysqli_query($con, $delete_query);
    
    if($delete_result) {
        // Delete the file from the directory
        $file_path = "pdf/".$file_name;
        if(file_exists($file_path)) {
            unlink($file_path);
            echo "File deleted successfully.";
        } else {
            echo "File not found.";
        }
    } else {
        echo "Error deleting file from database.";
    }
} else {
    echo "File not specified.";
}
?>
