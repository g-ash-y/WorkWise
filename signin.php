
<?php
session_start();
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='learning management sys';


$con=mysqli_connect($HOSTNAME,$USERNAME,$PASSWORD,$DATABASE);
// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $usernamein = $_POST['usernamein'];
    $passwordin = $_POST['passwordin'];
    $user_typein = $_POST['user_typein'];
    $name=$_POST['name'];

    // Verify user credentials
    $sql="SELECT * FROM `signup` WHERE username='$usernamein' AND password='$passwordin'";
    $result=mysqli_query($con,$sql);
    
    if(mysqli_num_rows($result) == 1){
        $_SESSION['user_logged_in'] = true;
        $_SESSION['usernamein'] = $usernamein;

        $row = mysqli_fetch_assoc($result);

        // Store the 'name' value from the fetched row into session
        $_SESSION['name'] = $row['name'];
       // Store reg_no in session for later use
        header('location:index.php');
    } else{
        
    echo '<div id="popup-overlay" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0, 0, 0, 0.5); z-index: 999;"></div>
          <div id="popup" style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%); background-color: #fff; padding: 20px; border: 1px solid #ccc; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); z-index: 1000;">
            <p style="margin: 0; text-align: center; color: darkblue;"><b>Invalid credentials try again</b></p>
            <button onclick="dismissPopup()" style="margin-top: 10px; padding: 5px 10px; background-color: blue; color: white; border-radius: 50px; cursor: pointer;">Dismiss</button>
          </div>
          <script>
            function dismissPopup() {
              document.getElementById("popup-overlay").style.display = "none";
              document.getElementById("popup").style.display = "none";
            }
          </script>';
          header("Location: signup.php");

    }
}

?>


