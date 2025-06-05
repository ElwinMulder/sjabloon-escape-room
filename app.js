let timerDuration = 5 * 60;
let timerDisplay = document.getElementById("timer");
let answeredBoxes = 0;

function startTimer() {
  let interval = setInterval(() => {
    let minutes = Math.floor(timerDuration / 60);
    let seconds = timerDuration % 60;
    timerDisplay.textContent = `${minutes}:${seconds < 10 ? "0" + seconds : seconds}`;
    timerDuration--;

    if (timerDuration < 0) {
      clearInterval(interval);
      alert("De tijd is om!");
    }
  }, 1000);
}

function openModal(index) {
  const box = document.querySelector(`.box${index + 1}`);
  if (box.classList.contains("answered")) return;

  document.getElementById("question").innerText = box.dataset.question;
  document.getElementById("modal").dataset.correctAnswer = box.dataset.answer.toLowerCase();
  document.getElementById("modal").dataset.index = index;
  document.getElementById("answer").value = "";
  document.getElementById("feedback").innerText = "";
  document.getElementById("overlay").style.display = "block";
  document.getElementById("modal").style.display = "block";
}

function closeModal() {
  document.getElementById("modal").style.display = "none";
  document.getElementById("overlay").style.display = "none";
}

function checkAnswer() {
  const userAnswer = document.getElementById("answer").value.trim().toLowerCase();
  const correctAnswer = document.getElementById("modal").dataset.correctAnswer;
  const boxIndex = document.getElementById("modal").dataset.index;
  const box = document.querySelector(`.box${parseInt(boxIndex) + 1}`);

  if (userAnswer === correctAnswer) {
    document.getElementById("feedback").innerText = "✅ Correct!";
    box.classList.add("answered");
    box.style.display = "none";
    answeredBoxes++;

    closeModal();

    if (answeredBoxes >= 3) {
      setTimeout(() => {
        window.location.href = "room_2.php";
      }, 1000);
    }
  } else {
    document.getElementById("feedback").innerText = "❌ Helaas, probeer opnieuw.";
  }
}

window.onload = function () {
  startTimer();

  document.getElementById("submit").addEventListener("click", checkAnswer);
  document.getElementById("close").addEventListener("click", closeModal);

  document.querySelectorAll(".vraag-box").forEach((box, index) => {
    box.addEventListener("click", () => openModal(index));
  });
};
