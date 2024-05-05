// Sample messages data
const messagesData = [
    { sender: 'Teacher', content: 'Welcome to the chatroom!' },
    { sender: 'Student', content: 'Hi teacher!' }
];

// Sample attendance data
const students = ['Student 1', 'Student 2', 'Student 3'];

// Function to display messages
function displayMessages() {
    const messagesContainer = document.getElementById('messages');
    messagesContainer.innerHTML = '';
    messagesData.forEach(message => {
        const messageDiv = document.createElement('div');
        messageDiv.innerHTML = `<strong>${message.sender}:</strong> ${message.content}`;
        messagesContainer.appendChild(messageDiv);
    });
}

// Function to display attendance list
//function displayAttendance() {
 //   const attendanceList = document.getElementById('attendanceList');
   // attendanceList.innerHTML = '';
    //students.forEach(student => {
      //  const listItem = document.createElement('li');
        //listItem.textContent = student;
        //attendanceList.appendChild(listItem);
    //});
//}

// Function to send a message
function sendMessage() {
    const messageInput = document.getElementById('messageInput');
    const messageContent = messageInput.value.trim();
    if (messageContent !== '') {
        messagesData.push({ sender: 'Teacher', content: messageContent });
        displayMessages();
        messageInput.value = '';
    }
}

// Initial display
displayMessages();
displayAttendance();
