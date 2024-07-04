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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>Document</title>
    <style>
      body {
          font-family: Arial, sans-serif;
          background-image: url(notesharing3.jpg);
          background-repeat: no-repeat;
          background-size: cover; /* Cover the entire viewport */
          background-position: center;
      }
      .container {
          max-width: 100%;
          margin: 0 auto;
          padding: 20px;
          display: flex; /* Use flexbox to stack items */
          flex-direction: column; /* Stack items vertically */
          align-items: center;
          justify-content: space-around;
      }
      input[type="file"] {
          margin-bottom: 10px;
      }
      button {
          padding: 10px 20px;
         background-color: rgb(5, 15, 73);
          color: rgb(241, 243, 247);
          border: none;
          cursor: pointer;
          width: 100%; /* Uniform width for buttons */
          height: 100%; /* Uniform height for buttons */
          margin: 5px; /* Adjust margin */
      }
      button:hover {
          background-color: #1d509c;
      }
      .upload-box {
        border: 2px solid #282e5c;
        background-color: #eaebfe;
        margin: 0 auto;
        display: block; /* Change from inline-block to block */
        padding: 20px;
        width: 50%;
        overflow: hidden;
      }

      .file-list {
        border: 2px solid #424078;
        background-color: #eaebfe;
        display: block; /* Change from inline-block to block */
        margin-top: 50px;
        padding: 100px;
        width: 100%;
        overflow: hidden;
      }
      
      .file-link {
        display: block;
        margin-bottom: 10px;
        margin-bottom: 15px;
        padding: 15px 25px;
      }
      
      .file-link {
          display: block;
          margin-bottom: 10px;
          color: black; /* Change text color to black */
          text-decoration: none;
      }
      .delete-container {
            display: inline-block;
            background-color: red;
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer; /* Add cursor pointer */
        }

        .delete-link {
            color: white;
            text-decoration: none;
        }
  </style>
</head>
<body>
<div>
  <nav>
      <div class="logo">
          <img src="workwise.png" alt="..." height="50%" width="50%">
      </div>
      <ul>
          <li><a href="index.html">HOME</a></li>
          <li><a href="studt.html">STUDY LINK</a></li>
          <!--
          <li><a href="chat.html">CHAT</a></li>
          -->
          <li><a href="attend.php">ATTENDANCE MARKER</a></li>
          <li><a href="note.html" class="active">NOTE SHARING</a></li>
      </ul>
  </nav>
</div>
<br>
<h1 style="text-align: center;"><b>NOTE-SHARING</b></h1>
<div class="container">
  <div class="upload-box">
    <?php
      if(isset($_POST['btn_img'])) {
        $username = $_SESSION['usernamein'];
        $filename = $_FILES["choosefile"]["name"];
        $tempfile = $_FILES["choosefile"]["tmp_name"];
        $folder = "pdf/".$filename; // Change folder path accordingly
        $sql = "INSERT INTO `note_sharing` (`username`, `image`) VALUES ('$username', '$filename')";
        if($filename == "") {
          echo "<div class='alert alert-danger' role='alert'><h4 class='text-center'>Blank not Allowed</h4></div>";
        } else {
          $result = mysqli_query($con, $sql);
          move_uploaded_file($tempfile, $folder);
          echo "<div class='alert alert-success' role='alert'><h4 class='text-center'>File uploaded</h4></div>";
        }
      }
    ?>
    <h2> DROP FILES HERE</h2>
    <form method="post" enctype="multipart/form-data">
      <input type="file" id="fileInput" accept=".pdf,.doc,.docx,.txt" name="choosefile">
      <button type="submit" name="btn_img">Upload File</button>
    </form>
  </div>
  <div class="file-list">
    <h3>Uploaded Files:</h3>
    <?php
      $fetch_query = "SELECT `image` FROM `note_sharing` WHERE `username` = '$username'";
      $fetch_result = mysqli_query($con, $fetch_query);
      while($row = mysqli_fetch_assoc($fetch_result)) {
        $file_name = $row['image'];
        $file_path = "pdf/".$file_name;
        echo "<div><a href='$file_path' class='file-link' target='_blank'>$file_name</a> ";
        echo "<div class='delete-container' data-file='$file_name'>Delete</div></div>";
    
      }
    ?>
  </div>
</div>

<script>
  $(document).ready(function() {
    $(".delete-container").click(function() {
      var fileToDelete = $(this).data("file");
      if (confirm("Are you sure you want to delete this file?")) {
        $.ajax({
          type: "GET",
          url: "delete.php",
          data: { file: fileToDelete },
          success: function(response) {
            alert(response); // Display response from delete.php
            // Remove the deleted file from the file list
            $("a.file-link[href='pdf/" + fileToDelete + "']").parent().remove();
          },
          error: function(xhr, status, error) {
            alert("Error deleting file: " + error);
          }
        });
      }
    });
  });
</script>

</body>
</html>
