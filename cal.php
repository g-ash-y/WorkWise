<?php
$HOSTNAME='localhost';
$USERNAME='root';
$PASSWORD='';
$DATABASE='learning management sys'; // corrected the database name, removed spaces

// Establish connection
$con = mysqli_connect($HOSTNAME, $USERNAME, $PASSWORD, $DATABASE);

// Check connection
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

// Check if the form has been submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve data from the forms
    $date = $_POST["eventDate"];
    $eventName = $_POST["eventName"];

    // Prepare SQL statement to insert data into the table
    $sql = "INSERT INTO calender (date, event) VALUES (?, ?)";

    // Prepare and bind parameters
    $stmt = $con->prepare($sql);
    $stmt->bind_param("ss", $date, $eventName);

    // Execute the SQL statement
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $con->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
mysqli_close($con);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Interactive Calendar with Events</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>
      body {
            font-family: Arial, sans-serif;
            background-image: url(calpic2.jpg);
            background-repeat: no-repeat;
            background-size: cover; /* Cover the entire viewport */
           background-position: center;
           margin: 0;
           padding: 0;
       }
       H1{
           font-style: italic;
           color: rgb(21, 12, 72);
       }

       #calendarContainer {
           width: 300px;
           margin: 0 auto;
           position: relative;
       }

       #calendarHeader {
           display: flex;
           justify-content: space-between;
           align-items: center;
           margin-bottom: 10px;
       }

       #prevMonth, #nextMonth {
           background-color: #2948a8;
           color: #fff;
           border: none;
           padding: 5px 10px;
           border-radius: 5px;
           cursor: pointer;
           outline: none;
       }

       #prevMonth:hover, #nextMonth:hover {
           background-color: #7f8bc9;
       }

       #monthYearDisplay {
           font-size: 18px;
           font-weight: bold;
           color: #333;
       }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 2px solid #040413;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #99aeed;
        }

        td {
            cursor: pointer;
            background-color: rgb(213, 217, 235);
        }

        #eventForm {
            display: none;
            margin-top: 20px;
            text-align: center;
        }

        #eventList {
            margin-top: 20px;
            text-align: center;
        }

        #eventList ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            text-align: center;
        }

        #eventList li {
            margin-bottom: 5px;
            text-align: center;
        }
        input{
            text-align: center;
            color: rgb(6, 4, 100);
        }

        nav {
            background-color: #022954;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-top: 0%;
            width: auto;
            margin-left: 0%;
            margin-right: 0%;
        }
        .logo img {
            width: 100px;color: #acaebc;
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
        a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            transition: background-color 0.3s ease;
        }
        a:hover {
            background-color: #b0b8ce;
        }
        a.active {
            background-color: #5e6aa4;
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
                <li><a href="index.php">HOME</a></li>
                <li><a href="self.html">SELF</a></li>
                <li><a href="pomo.html">POMODORO TIMER</a></li>
                <li><a href="todo.php">TO-DO-LIST</a></li>
                <li><a href="cal.php" class="active">CALENDAR SCHEDULING</a></li>
            </ul>
        </nav>
    </div>
    <b>
    <center><h1>CALENDER SCHEDULER</h1></center></b>
    <br>
    <center><h style="text-align: center; font-size: 30px;">Click on any date to schedule the calendar.</h></center>
    <br>
    <center><div id="calendarContainer">
        <div id="calendarHeader">
            <button id="prevMonth">&lt; Previous</button>
            <h2 id="monthYearDisplay"></h2>
            <button id="nextMonth">Next &gt;</button>
        </div>
        <div id="calendar"></div>
    </div>
    <div id="eventForm">
        <label for="eventDate">Event Date:</label>
        <input type="date" id="eventDate" name="eventDate" required>
        <label for="eventName">Event Name:</label>
        <input type="text" id="eventName" name="eventName" required>
        <button id="addEvent">Add Event</button>
    </div>
    <div id="eventList" style="text-align: center;">
       <center> <h2>Events</h2></center>
        <ul id="eventsByDate" style="padding-left: 40%;"></ul>
    </div>
</center>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        var calendarContainer = document.getElementById('calendar');
        var calendarHeader = document.getElementById('calendarHeader');
        var monthYearDisplay = document.getElementById('monthYearDisplay');
        var prevMonthButton = document.getElementById('prevMonth');
        var nextMonthButton = document.getElementById('nextMonth');
        var eventForm = document.getElementById('eventForm');
        var eventDateInput = document.getElementById('eventDate');
        var eventNameInput = document.getElementById('eventName');
        var addEventButton = document.getElementById('addEvent');
        var eventsByDateList = document.getElementById('eventsByDate');

        var currentDate = new Date();
        var currentMonth = currentDate.getMonth();
        var currentYear = currentDate.getFullYear();
        var eventsData = {};

        function daysInMonth(month, year) {
            return new Date(year, month + 1, 0).getDate();
        }

        function renderCalendar(month, year) {
            var calendarHtml = '<table>';
            calendarHtml += '<tr><th>Sun</th><th>Mon</th><th>Tue</th><th>Wed</th><th>Thu</th><th>Fri</th><th>Sat</th></tr>';

            var firstDay = new Date(year, month, 1).getDay();
            var totalDays = daysInMonth(month, year);

            var dayCounter = 1;

            for (var i = 0; i < 6; i++) {
                calendarHtml += '<tr>';
                for (var j = 0; j < 7; j++) {
                    if ((i === 0 && j < firstDay) || dayCounter > totalDays) {
                        calendarHtml += '<td></td>';
                    } else {
                        calendarHtml += '<td data-date="' + year + '-' + (month + 1) + '-' + dayCounter + '">' + dayCounter + '</td>';
                        dayCounter++;
                    }
                }
                calendarHtml += '</tr>';
            }

            calendarHtml += '</table>';
            calendarContainer.innerHTML = calendarHtml;

            // Attach click event to each date cell
            var dateCells = document.querySelectorAll('#calendar td[data-date]');
            dateCells.forEach(function (cell) {
                cell.addEventListener('click', function () {
                    showEventForm(cell.getAttribute('data-date'));
                });
            });

            // Update month and year display
            monthYearDisplay.textContent = new Date(year, month).toLocaleString('default', { month: 'long' }) + ' ' + year;
        }

        // Function to switch to the previous month
        function prevMonth() {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentMonth, currentYear);
        }

        // Function to switch to the next month
        function nextMonth() {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentMonth, currentYear);
        }

        // Event listeners for previous and next month buttons
        prevMonthButton.addEventListener('click', prevMonth);
        nextMonthButton.addEventListener('click', nextMonth);

        function showEventForm(date) {
            eventDateInput.value = date;
            eventForm.style.display = 'block';
        }

        function addEvent() {
            var date = eventDateInput.value;
            var eventName = eventNameInput.value;

            if (date && eventName) {
                // Handle the event data
                if (!eventsData[date]) {
                    eventsData[date] = [];
                }

                eventsData[date].push(eventName);
                renderEventsList();
                clearEventForm();

                // AJAX request to send form data to PHP script
                var formData = new FormData();
                formData.append('eventDate', date);
                formData.append('eventName', eventName);

                fetch('cal.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.text())
                .then(data => {
                    // Handle PHP script response
                    console.log(data);
                })
                .catch(error => {
                    console.error('Error:', error);
                });
            }
        }

        function renderEventsList() {
            eventsByDateList.innerHTML = '';
            for (var date in eventsData) {
                var eventsList = document.createElement('li');
                eventsList.innerHTML = '<strong>' + date + ':</strong> ' + eventsData[date].join(', ');
                eventsByDateList.appendChild(eventsList);
            }
        }

        function clearEventForm() {
            eventDateInput.value = '';
            eventNameInput.value = '';
            eventForm.style.display = 'none';
        }

        addEventButton.addEventListener('click', addEvent);

        renderCalendar(currentMonth, currentYear);
    });
</script>
</body>
</html>
