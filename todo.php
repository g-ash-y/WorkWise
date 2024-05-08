
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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve task and priority from the form
    $task = $_POST['task'];
    $priority = $_POST['priority'];

    // Sanitize and validate the input data (optional)
    //$task = htmlspecialchars($task);
    //$priority = htmlspecialchars($priority);

    // Retrieve username from session variable
    $usernamein = $_SESSION['usernamein'];

    // Prepare SQL statement to insert data into task_schedule table
    $stmt = $con->prepare("INSERT INTO task_schedule (username, task, priority) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $usernamein, $task, $priority);
    
    // Execute the prepared statement
    if ($stmt->execute() === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();


}

$sql = "SELECT task, priority FROM task_schedule WHERE username = ?";
$stmt = $con->prepare($sql);
$stmt->bind_param("s", $_SESSION['usernamein']);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prioritized To-Do List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> 
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <style>

<style>
        * {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            background-image: url('todobg.jpg');
            background-repeat: no-repeat;
            background-size: cover;
            height: 100vh;
        }

        nav {
            background-color:  #022954;;
            padding: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: auto;
            margin-left: auto;
            margin-right: auto;
        }

        .logo img {
            width: 100px;
            color: #ccc;
        }

        .nav-ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: row; /* Display navbar items horizontally */
        }

        .nav-li {
            margin-right: 20px;
        }

        a {
            color: #fff;
            text-decoration: none;
            padding: 10px;
            display: block;
            transition: background-color 0.3s ease;
        }

        a:hover {
            background-color:  rgb(61, 81, 194);;
        }

        a.active {
            background-color:  rgb(61, 81, 194);;
        }

        #todo-container {
            color:white;
            width: 700px;
            background-color: rgb(119,139,165);
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            margin-top: 5%;
            margin-left: auto;
            margin-right: auto;
        }

        #todo-list {
            list-style: none;
            padding: 0;
        }

        .task {
            border-bottom: 1px solid #e0e0e0;
            padding: 10px 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .task input[type="checkbox"] {
            margin-right: 10px;
        }

        .priority-high {
    color: black;
   
    text-decoration-color: red;
    text-decoration-line: underline;
}

.priority-medium {
    color: black;
    text-decoration-color: rgba(251, 152, 24, 0.808);
    text-decoration-line: underline;
}

.priority-low {
    color: black;
    text-decoration-color: rgb(12, 241, 12);
    text-decoration-line: underline;
}

        #add-task {
            margin-top: 20px;
        }

        #task-input {
            width: calc(100% - 112px);
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        #priority-select {
            width: 100px;
            padding: 8px;
            border: 1px solid #ccc;
            border-radius: 4px;
            margin-right: 10px;
        }

        #add-button {
            background-color: rgb(255,255,255);
            color: black;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
        .todo-container {
            width: 800px;
            height: 400px;
            background-color: rgba(174,198,207,0.7);
        }

        .delete-button {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>
<body style="background-image: url('todobg.jpg');">
    <nav>
        <div class="logo">
            <img src="workwise.png" alt="..." height="50%" width="50%">
        </div>
        <ul class="nav-ul">
            <li class="nav-li"><a href="index.html">HOME</a></li>
            <li class="nav-li"><a href="self.html">SELF</a></li>
            <li class="nav-li"><a href="pomo.html">POMODORO TIMER</a></li>
            <li class="nav-li"><a href="todo.php" class="active">TO-DO-LIST</a></li>
            <li class="nav-li"><a href="cal.html">CALENDAR SCHEDULING</a></li>
        </ul>
    </nav>
    <br>
    <br>
    <br>
    <h1 style="font-family:'times-new-roman'; text-align: center;" ><b>Prioritized To-Do List</b></h1>

    <div id="todo-container">
        <h3>YOUR LIST:</h3>
        
        <ol id="todo-list"></ol>
        
        <div id="add-task"> 
            <input type="text" id="task-input" placeholder="Add a new task" name="task">
            <br>
            <br>
            <select id="priority-select">
                <option value="high" name="priority">HIGH</option>
                <option value="medium" name="priority">MEDIUM</option>
                <option value="low" name="priority">LOW</option>
            </select>
            <button id="add-button" onclick="addTask()">Add</button>
        </div>
    </div>

    <center><br><br><h1>PENDING LIST</h1></center>
   <center> <div class="todo-container">

    <ol id="pending-list">
        <?php
        // Check if there are any tasks
        if ($result->num_rows > 0) {
            // Output data of each row
            while ($row = $result->fetch_assoc()) {
                // Output each task as an HTML element
                $taskText = htmlspecialchars($row["task"]);
                $priority = htmlspecialchars($row["priority"]);
                echo "<li class='task priority-$priority'><input type='checkbox' onchange='toggleTask(event)'><span>$taskText</span><button class='delete-button' onclick='deleteTask(event)'>Delete</button></li>";
            }
        } else {
            echo "<p style='text-align: center;'>YOU ARE UPTO DATE <br> YOUR TASKS ARE ALL COMPLETED</p>";
        }
        ?>
    </ol>
    </div></center>

    <script>
       function addTask() {
    var taskInput = document.getElementById("task-input");
    var prioritySelect = document.getElementById("priority-select");
    var taskText = taskInput.value.trim();
    var priority = prioritySelect.value;

    if (taskText !== "") {
        // AJAX request
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                // On success, add task to the list
                var todoList = document.getElementById("todo-list");

                var taskItem = document.createElement("li");
                taskItem.className = "task";

                var checkbox = document.createElement("input");
                checkbox.type = "checkbox";
                checkbox.addEventListener("change", toggleTask);

                var taskTextElement = document.createElement("span");
                taskTextElement.innerText = taskText;

                var deleteButton = document.createElement("button");
                deleteButton.innerText = "Delete";
                deleteButton.className = "delete-button"; // Add class for styling
                deleteButton.addEventListener("click", deleteTask1);

                taskItem.appendChild(checkbox);
                taskItem.appendChild(taskTextElement);
                taskItem.appendChild(deleteButton);

                if (priority === "high") {
                    taskItem.classList.add("priority-high");
                } else if (priority === "medium") {
                    taskItem.classList.add("priority-medium");
                } else if (priority === "low") {
                    taskItem.classList.add("priority-low");
                }

                todoList.appendChild(taskItem);

                taskInput.value = "";
            }
        };
        xhttp.open("POST", "todo.php", true);
        xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhttp.send("task=" + taskText + "&priority=" + priority);
    }
}

function toggleTask(event) {
    var taskTextElement = event.target.nextElementSibling;
    if (event.target.checked) {
        taskTextElement.style.textDecoration = "line-through";
    } else {
        taskTextElement.style.textDecoration = "none";
    }
}

function deleteTask(event) {
    var taskItem = event.target.parentElement;
    var pendingList = document.getElementById("pending-list");

    // Remove the task from the database via AJAX
    var taskText = taskItem.querySelector("span").innerText;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // On successful deletion from the database, remove the task from the UI
            pendingList.removeChild(taskItem);
        }
    };
    xhttp.open("POST", "delete_task.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("task=" + encodeURIComponent(taskText));
}
function deleteTask1(event) {
    var taskItem = event.target.parentElement;
    var todoList = document.getElementById("todo-list");

    // Remove the task from the database via AJAX
    var taskText = taskItem.querySelector("span").innerText;
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // On successful deletion from the database, remove the task from the UI
            todoList.removeChild(taskItem);
        }
    };
    xhttp.open("POST", "delete_task.php", true);
    xhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    xhttp.send("task=" + encodeURIComponent(taskText));
}

       
    </script>
</body>
</html>