<?php
// Part 1: Database Connection and Message Insertion

$servername = "localhost"; // Change to your server
$username = "root"; // Change to your database username
$password = ""; // Change to your database password
$dbname = "learning management sys"; // Your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert the message into the "chatbox" table if POST data is present
if (isset($_POST['message'])) {
    $chat = $_POST['message'];
    $date = date('Y-m-d'); // Current date
    $time = date('H:i:s'); // Current time
    
    $sql = "INSERT INTO chatbox (chat, date, time) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('sss', $chat, $date, $time);

    if ($stmt->execute()) {
        echo "Message sent successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}

$conn->close(); // Close the database connection
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Teacher Chatroom</title>
    <style>
        /* Part 2: CSS Styling */
        body {
            background-image: url('classroom.jpeg');
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: rgb(68, 107, 179);
        }

        .chat-container {
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            border: 1px solid #98a6db;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(4, 1, 24, 0.1);
            background-color: rgb(169, 201, 247);
            margin-top: 10px;
        }

        .messages {
            height: 300px;
            overflow-y: scroll;
            border: 1px solid #323557;
            padding: 10px;
            margin-bottom: 10px;
        }

        input[type="text"] {
            width: calc(100% - 70px);
            padding: 10px;
            margin-right: 10px;
            border: 1px solid #a6aed3;
            border-radius: 5px;
        }

        button {
            padding: 10px 20px;
            background-color: rgb(164, 184, 241);
            color: black;
            border: none;
            border-radius: 15px;
            cursor: pointer;
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
  color: white;
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
        <nav>
            <div class="logo">
                <img src="workwise.png" atl="..." height="50%" width="50%">
            </div>
            <div>
            <ul>
                <li><a href="index.html">HOME</a></li>
                <li><a href="studt.html">STUDY LINK</a></li>
                <li><a href="chat.php" class="active">CHAT</a></li>
                <li><a href="attend.php">ATTENDANCE MARKER</a></li>
                <li><a href="note.html" >NOTE SHARING</a></li>
            </ul>
            </div>
        </nav>
    </div>
    <h1 style="text-align: center; margin-top: 20px; margin-bottom: 15px;"><b>CHAT ROOM</b></h1>
    
    <div class="chat-container">
        <div class="messages" id="messages">
            <!-- Messages will be appended here -->
        </div>
        <input type="text" id="messageInput" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
    </div>

    <script>
        // Part 3: JavaScript for Chat Functionality
        const messagesData = [
            { sender: 'Teacher', content: 'Welcome to the chatroom!' },
            { sender: 'Student', content: 'Hi teacher!' }
        ];

        function displayMessages() {
            const messagesContainer = document.getElementById('messages');
            messagesContainer.innerHTML = '';
            messagesData.forEach(message => {
                const messageDiv = document.createElement('div');
                messageDiv.innerHTML = `<strong>${message.sender}:</strong> ${message.content}`;
                messagesContainer.appendChild(messageDiv);
            });
        }

        function sendMessage() {
            const messageInput = document.getElementById('messageInput');
            const messageContent = messageInput.value.trim();

            if (messageContent !== '') {
                fetch('', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `message=${encodeURIComponent(messageContent)}`,
                })
                .then(response => response.text())
                .then(data => {
                    console.log(data);
                    messagesData.push({ sender: 'Teacher', content: messageContent });
                    displayMessages();
                    messageInput.value = ''; // Clear the input field
                })
                .catch(error => console.error('Error:', error));
            }
        }

        displayMessages(); // Initialize the display
    </script>
</body>
</html>
