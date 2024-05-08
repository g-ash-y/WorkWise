<?php
// Database Connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "learning management sys";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Insert a message into the "chatbox" if POST data is present
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

// Retrieve chat history from the "chatbox"
$chat_history = [];
$sql = "SELECT chat, date, time FROM chatbox ORDER BY date, time";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $chat_history[] = array(
            'chat' => $row['chat'],
            'date' => $row['date'],
            'time' => $row['time']
        );
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chat Room</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: rgb(68, 107, 179);
            
            
        }

        .chat-container {
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border: 1px solid #98a6db;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background-color: rgb(169, 201, 247);
        }

        .messages {
            height: 300px;
            overflow-y: auto;
            border: 1px solid #323557;
            padding: 10px;
            margin-bottom: 10px;
            background-color: white;
        }

        .chat-history {
            height: 200px;
            overflow-y: auto;
            border: 1px solid #323557;
            padding: 10px;
            background-color: lightgray;
            margin-top: 10px;
        }

        input[type="text"] {
            width: calc(100% - 80px);
            padding: 10px;
            border: 1px solid #a6aed3;
            border-radius: 5px;
        }

        button {
            padding: 10px;
            background-color: rgb(164, 184, 241);
            color: black;
            border-radius: 15px;
            border: none;
            cursor: pointer;
        }

        button:hover {
            background-color: lightblue;
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
    <br>
    <br>
    <div style="padding: 20px;">
    <h1 style="text-align: center;">CHAT ROOM</h1>
    
    <div class="chat-container">
        <!-- Heading for the Chat Room -->
        

        <div class="messages" id="messages">
            <!-- Display new messages here -->
        </div>
        
        <input type="text" id="messageInput" placeholder="Type your message...">
        <button onclick="sendMessage()">Send</button>
        <button onclick="showChatHistory()">Show Chat History</button> <!-- Button to fetch chat history -->
    </div>

    <div class="chat-history" id="chatHistory">
        <!-- Heading for the Chat History -->
        <h2>Chat History</h2>

        <!-- Display chat history here -->
    </div>
    </div>
    <script>
        function appendMessage(date, time, content) {
            const messagesContainer = document.getElementById('messages');
            const messageDiv = document.createElement('div');
            messageDiv.innerHTML = `<strong>${date} ${time}:</strong> ${content}`;
            messagesContainer.appendChild(messageDiv);
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
                    const now = new Date();
                    const date = now.toISOString().split('T')[0];
                    const time = now.toLocaleTimeString();
                    appendMessage(date, time, messageContent);
                    messageInput.value = ''; // Clear the input field
                })
                .catch(error => console.error('Error sending message:', error));
            }
        }

        function showChatHistory() {
            const chatHistory = <?php echo json_encode($chat_history); ?>; // Fetch chat history from PHP
            const chatHistoryContainer = document.getElementById('chatHistory');

            chatHistoryContainer.innerHTML = ''; // Clear existing chat history
            chatHistory.forEach(chat => {
                const chatDiv = document.createElement('div');
                chatDiv.innerHTML = `<strong>${chat.date} ${chat.time}:</strong> ${chat.chat}`;
                chatHistoryContainer.appendChild(chatDiv);
            });
        }
    </script>
</body>
</html>
