<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendance Marker</title>
    <link rel="stylesheet" href="attend.css">
</head>
<body>
    <div class="container">
        <h2>Mark Absent for a Specific Date</h2>
        <!-- Form to select the date and mark attendance -->
        <form method="post">
            <label for="date">Select Date:</label>
            <input type="date" id="date" name="date" required>

            <label for="rollno">Roll Number:</label>
            <input type="text" id="rollno" name="rollno" required>

            <button type="submit">Mark Absent</button>
        </form>

        <?php
        // Database connection parameters
        $servername = "localhost"; // Adjust as needed
        $username = "root"; // Adjust to your MySQL username
        $password = ""; // Adjust to your MySQL password
        $dbname = "learning management sys"; // Adjust to your database name

        // Establish a database connection
        $conn = new mysqli($servername, $username, $password, $dbname);

        // Check if the connection is successful
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Handle form submission to mark absent
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $date = $_POST['date'];
            $rollno = $_POST['rollno'];

            // Ensure the date is formatted correctly to match column names
            $date_column = str_replace("-", "_", $date);

            // Check if the roll number exists in "namelist"
            $check_sql = "SELECT `name` FROM `namelist` WHERE `rollno` = '$rollno'";
            $result_check = $conn->query($check_sql);

            if ($result_check->num_rows > 0) {
                // If roll number exists, mark it as "Absent" for the given date
                $update_sql = "UPDATE `dateattend` SET `$date_column` = 'Absent' WHERE `rollno` = '$rollno'";

                if ($conn->query($update_sql) === TRUE) {
                    echo "<p>Roll number $rollno marked as absent for $date.</p>";
                } else {
                    echo "<p>Error: " . $conn->error . "</p>";
                }
            } else {
                echo "<p>Roll number $rollno not found in namelist.</p>";
            }
        }
        ?>

        <button onclick="showAttendance()">Finish</button>

        <div id="attendanceTable" style="display: none;">
            <h3>Attendance for Selected Date</h3>
            <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $date = $_POST['date'];
                $date_column = str_replace("-", "_", $date);

                // Retrieve all roll numbers from "namelist"
                $namelist_sql = "SELECT `rollno`, `name` FROM `namelist`";
                $namelist_result = $conn->query($namelist_sql);

                if ($namelist_result->num_rows > 0) {
                    echo "<table border='1'>";
                    echo "<tr>
                          <th>Roll Number</th>
                          <th>Name</th>
                          <th>Attendance</th>
                          </tr>";

                    // Loop through all roll numbers and check attendance status
                    while ($row = $namelist_result->fetch_assoc()) {
                        $rollno = $row['rollno'];
                        $name = $row['name'];

                        // Determine attendance status for the given date
                        $attendance_sql = "SELECT `$date_column` FROM `dateattend` WHERE `rollno` = '$rollno'";
                        $attendance_result = $conn->query($attendance_sql);

                        if ($attendance_result->num_rows > 0) {
                            $attendance = $attendance_result->fetch_assoc()[$date_column];
                            $attendance = $attendance == "Absent" ? "Absent" : "Present";
                        } else {
                            $attendance = "Present"; // Default to Present if not explicitly marked as Absent
                        }

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
            ?>

        </div>
    </div>

    <script>
    function showAttendance() {
        document.getElementById('attendanceTable').style.display = 'block';
    }
    </script>
</body>
</html>
