const startEl = document.getElementById("start");
const stopEl = document.getElementById("stop");
const resetEl = document.getElementById("reset");
const timerEl = document.getElementById("timer");
const breakTime=document.getElementById("Break");
let interval;
let timeLeft = 1500; // 25 minutes

function updateTimer() {
  let minutes = Math.floor(timeLeft / 60);
  let seconds = timeLeft % 60;
  let formattedTime = `${minutes.toString().padStart(1, "0")}:${seconds.toString().padStart(1, "0")}`;
  timerEl.innerHTML = formattedTime;
}

function startTimer() {
  interval = setInterval(() => {
    timeLeft--;
    updateTimer();
    if (timeLeft === 0) {
      clearInterval(interval);
      alert("Time's up!");

   
    }
  }, 1000);
}
function breakTimefun(){
 
      timeLeft = 300; // 5 minutes interval
      updateTimer();
      interval = setInterval(() => {
        timeLeft--;
        updateTimer();
        if (timeLeft === 0) {
          clearInterval(interval);
          alert("Time's up for the break!");
          timeLeft = 1500; // Reset to 25 minutes
          updateTimer();
        }
      }, 1000);
    }
  


function stopTimer() {
  clearInterval(interval);
}

function resetTimer() {
  clearInterval(interval);
  timeLeft = 1500; // Reset to 25 minutes
  updateTimer();
}

startEl.addEventListener("click", startTimer);
stopEl.addEventListener("click", stopTimer);
resetEl.addEventListener("click", resetTimer);
breakTime.addEventListener("click",breakTimefun);
