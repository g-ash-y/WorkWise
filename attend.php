<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Marker</title>
    <link rel="stylesheet" href="attend.css">
    <style>
       body {
  font-family: Arial, sans-seri;
  background-image: url(attendbg.png); 
  background-repeat: no-repeat; 
  background-size: cover;
}

.container {
  text-align: center;
}
nav {
  background-color: #022954;
  padding: 0px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  margin-top: 0%;
  width: auto;
  margin-left: 0%;
  margin-right: 0%;
}
.logo img {
  size: 100PX;
  width:200px;
  color: #5e6aa4;
}
ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
  display: flex;
}
li {
  margin-right: 20px;
}

*{
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

.logo img {
  width: 100px;
}

ul {
  list-style-type: none;
  margin: 0;
  padding: 0;
}
li {
    margin-right: 10px;
    background-color:#022954;
}
a {
  text-decoration: none;
  padding: 10px;
  transition: background-color 0.3s ease;
}

a.active {
  background-color: #5e6aa4;
}

a:hover {
  background: #b0b8ce;
}


    </style>
</head>
<body>

    <div>
        <!-- Navigation bar -->
        <nav>
            <div class="logo">
                <img src="workwise.png" alt="..." height="50%" width="50%">
            </div>
            <div>
                <ul>
                    <li><a href="index.html">HOME</a></li>
                    <li><a href="studt.html">STUDY LINK</a></li>
                    <li><a href="chat.php">CHAT</a></li>
                    <?php
                    // Check user_type to determine which links to display
                    session_start();
                    if ($_SESSION['user_type'] === 'teacher') {
                        echo '<li><a href="attend.php" class="active">ATTENDANCE MARKER</a></li>';
                        echo '<li><a href="note.html">NOTE SHARING</a></li>';
                    } elseif ($_SESSION['user_type'] === 'student') {
                        echo '<li><a href="attend.php">ATTENDANCE MARKER</a></li>';
                        echo '<li><a href="note.html">NOTE SHARING</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </nav>
    </div>
    <div class="container">
        <?php
        // Database connection parameters
        $servername = "localhost"; // Change as needed
        $username = "root"; // Your MySQL username
        $password = ""; // Your MySQL password
        $dbname = "learning management sys"; // Database name (corrected from the original)

        // Create a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check if the connection failed
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Check if user is logged in and determine user_type
        if (isset($_SESSION['user_type'])) {
            if ($_SESSION['user_type'] === 'teacher') {
                // Handle form submission for marking absent
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rollno']) && isset($_POST['attendance_date'])) {
                    $rollno = $_POST['rollno'];
                    $attendance_date = $_POST['attendance_date'];

                    // Check if the roll number exists in "namelist"
                    $check_sql = "SELECT `name` FROM `namelist` WHERE `rollno` = '$rollno'";
                    $result_check = $conn->query($check_sql);

                    if ($result_check->num_rows > 0) {
                        // Insert the absent record into "attendance"
                        $insert_sql = "INSERT INTO `attendance` (`rollno`, `attendance`, `date`) 
                                       VALUES ('$rollno', 'A', '$attendance_date')";

                        if ($conn->query($insert_sql) === TRUE) {
                            echo "<p>Roll number $rollno marked as absent on $attendance_date.</p>";
                        } else {
                            echo "<p>Error: " . $conn->error . "</p>";
                        }
                    } else {
                        echo "<p>Roll number $rollno not found in namelist.</p>";
                    }
                }
            

            // Display form to enter a date to view attendance for both teacher and student
            ?>
            <h2>Mark Absent</h2>
                <form method="post">
                    <label for="rollno">Roll Number:</label>
                    <input type="text" id="rollno" name="rollno" required>

                    <label for="attendance_date">Attendance Date:</label>
                    <input type="date" id="attendance_date" name="attendance_date" required>

                    <button type="submit">Mark Absent</button>
                </form>
                <?php
            }
            ?>
            <h2>View Attendance</h2>
            <form method="post">
                <label for="view_date">Enter Date:</label>
                <input type="date" id="view_date" name="view_date" required>
                <button type="submit" name="show_attendance">Show Attendance</button>
            </form>

            <div id="attendanceTable">
                <!-- Display results when form is submitted -->
                <?php
                if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['show_attendance'])) {
                    $view_date = $_POST['view_date']; // Date entered to view attendance

                    // Retrieve roll numbers marked absent on the specified date
                    $absent_sql = "SELECT `rollno` FROM `attendance` WHERE `attendance` = 'A' AND `date` = '$view_date'";
                    $absent_result = $conn->query($absent_sql);

                    if ($absent_result === false) {
                        echo "<p>Error in query: " . $conn->error . "</p>";
                    } else {
                        $absent_rollnos = [];
                        while ($row = $absent_result->fetch_assoc()) {
                            $absent_rollnos[] = $row['rollno']; // Corrected array syntax
                        }

                        // Retrieve all roll numbers from "namelist"
                        $namelist_sql = "SELECT `rollno`, `name` FROM `namelist`";
                        $namelist_result = $conn->query($namelist_sql);

                        if ($namelist_result->num_rows > 0) {
                            echo "<p>Attendance for date: $view_date</p>";
                            echo "<table border='1'>";
                            echo "<tr>
                                    <th>Roll Number</th>
                                    <th>Name</th>
                                    <th>Attendance</th>
                                  </tr>";

                            while ($row = $namelist_result->fetch_assoc()) {
                                $rollno = $row['rollno'];
                                $name = $row['name'];
                                $attendance = in_array($rollno, $absent_rollnos) ? 'Absent' : 'Present';

                                echo "<tr>
                                        <td>$rollno</td>
                                        <td>$name</td>
                                        <td>$attendance</td>
                                      </tr>";
                            }

                            echo "</table>";
                        } else {
                            echo "<p>No roll numbers found in namelist.</p>";
                        }
                    }
                }
                ?>
            </div>
        <?php
        } else {
            echo "<p>You are not authorized to view this page.</p>";
        }
        ?>
    </div>

    <!-- JavaScript to show attendance table -->
    <script>
        function showAttendance() {
            // Display the complete attendance table when "Show Attendance" is clicked
            document.getElementById('attendanceTable').style.display = 'block';
        }
    </script>
</body>
</html>
