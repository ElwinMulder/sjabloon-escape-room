let timeLeft = 60;
let timerInterval;

function startTimer() {
  const timerElement = document.getElementById("timer");
  if (!timerElement) return;

  clearInterval(timerInterval);
  timeLeft = 60;

  timerInterval = setInterval(() => {
    const minutes = Math.floor(timeLeft / 60);
    const seconds = timeLeft % 60;
    timerElement.textContent = `${minutes}:${seconds < 10 ? '0' : ''}${seconds}`;

    if (timeLeft <= 0) {
      clearInterval(timerInterval);
      alert("Tijd is op!");
    }

    timeLeft--;
  }, 1000);
}
