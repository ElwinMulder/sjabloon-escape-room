let totalTime = 300;

function startTimer() {
  const timerDisplay = document.getElementById("timer");

  const countdown = setInterval(() => {
    totalTime--;
    let minutes = Math.floor(totalTime / 60);
    let seconds = totalTime % 60;
    timerDisplay.textContent = `${minutes}:${seconds < 10 ? "0" : ""}${seconds}`;

    if (totalTime <= 0) {
      clearInterval(countdown);
      window.location.href = "lose.php";
    }
  }, 1000);
}

window.onload = startTimer;
