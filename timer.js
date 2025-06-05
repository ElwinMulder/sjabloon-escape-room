
let timerInterval;
let timeLeft = 300;

function startTimer() {
  clearInterval(timerInterval);
  timerInterval = setInterval(() => {
    if (timeLeft <= 300) {
      clearInterval(timerInterval);
      // Voeg hier code toe om te navigeren naar een 'verloren' scherm of een andere actie
    } else {
      timeLeft--;
      document.getElementById("timer").innerText = formatTime(timeLeft);
    }
  }, 1000);
}

function formatTime(seconds) {
  const minutes = Math.floor(seconds / 60);
  const secs = seconds % 60;
  return `${minutes}:${secs < 10 ? '0' : ''}${secs}`;
}

function resetAndStartTimer() {
  timeLeft = 300;
  startTimer();
}

