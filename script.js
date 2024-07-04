const startEl = document.getElementById("start");
const stopEl = document.getElementById("stop");
const resetEl = document.getElementById("reset");
const timerEl = document.getElementById("timer");
const breakTimeEl = document.getElementById("break");

let interval;
let timeLeft = parseInt(localStorage.getItem('timeLeft')) || 1500; // 25 minutes in seconds

function updateTimer() {
  let minutes = Math.floor(timeLeft / 60);
  let seconds = timeLeft % 60;
  let formattedTime = `${minutes.toString().padStart(2, "0")}:${seconds.toString().padStart(2, "0")}`;
  timerEl.innerHTML = formattedTime;
}

function startTimer() {
  if (!interval) {
    interval = setInterval(() => {
      timeLeft--;
      updateTimer();
      if (timeLeft === 0) {
        clearInterval(interval);
        alert("Time's up!");
        interval = null;
      }
    }, 1000);
    localStorage.setItem('timeLeft', timeLeft); // Store timeLeft in localStorage
    localStorage.setItem('interval', interval); // Store interval in localStorage
  }
}

function breakTimeFunc() {
  if (!interval) {
    timeLeft = 300; // 5 minutes
    updateTimer();
    interval = setInterval(() => {
      timeLeft--;
      updateTimer();
      if (timeLeft === 0) {
        clearInterval(interval);
        alert("Time's up for the break!");
        timeLeft = 1500; // Reset to 25 minutes
        updateTimer();
        interval = null;
      }
    }, 1000);
    localStorage.setItem('timeLeft', timeLeft); // Store timeLeft in localStorage
    localStorage.setItem('interval', interval); // Store interval in localStorage
  }
}

function stopTimer() {
  clearInterval(interval);
  interval = null;
  localStorage.removeItem('interval'); // Remove interval from localStorage
}

function resetTimer() {
  clearInterval(interval);
  interval = null;
  timeLeft = 1500; // Reset to 25 minutes
  updateTimer();
  localStorage.removeItem('timeLeft'); // Remove timeLeft from localStorage
  localStorage.removeItem('interval'); // Remove interval from localStorage
}

// Check if there's a stored interval, resume timer if it exists
const storedInterval = parseInt(localStorage.getItem('interval'));
if (storedInterval) {
  interval = storedInterval;
  updateTimer();
}

startEl.addEventListener("click", startTimer);
stopEl.addEventListener("click", stopTimer);
resetEl.addEventListener("click", resetTimer);
breakTimeEl.addEventListener("click", breakTimeFunc);
