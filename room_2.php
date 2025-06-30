<?php
session_start();

require_once('./dbcon.php');

try {
  $stmt = $db_connection->query("SELECT * FROM questions WHERE roomId = 1 LIMIT 3");
  $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Databasefout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Escape Room 1</title>
  <link rel="stylesheet" href="style.css" />
  <style>
    body {
      background-image: url(afbeeldingen/room-1.jpg);
      background-color: #0b0b0b;
      color: #00ff88;
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      height: 100vh;
      overflow: hidden;
    }
    #question-container {
      position: relative;
      width: 100vw;
      height: 100vh;
    }
    .box {
      position: absolute;
      background: rgba(0,255,136,0.2);
      border: 2px solid #00ff88;
      color: #00ff88;
      padding: 20px;
      cursor: pointer;
      user-select: none;
      font-weight: bold;
      border-radius: 8px;
      width: 150px;
      text-align: center;
    }
    .box1 { top: 20%; left: 10%; }
    .box2 { top: 70%; left: 59%; }
    .box3 { top: 75%; left: 30%; }

    #modal, #overlay {
      display: none;
      position: fixed;
      top: 0; left: 0; right:0; bottom:0;
      background: rgba(0,0,0,0.8);
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }
    #modal {
      background: #111;
      border: 2px solid #00ff88;
      padding: 20px;
      max-width: 400px;
      color: #00ff88;
      text-align: center;
      border-radius: 10px;
      z-index: 1010;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }
    #answer {
      padding: 10px;
      font-size: 1em;
      border: 1px solid #00ff88;
      background: #000;
      color: #00ff88;
      border-radius: 5px;
    }
    #feedback {
      height: 1.5em;
      font-weight: bold;
    }
    button {
      background: #00ff88;
      color: #000;
      border: none;
      padding: 10px;
      cursor: pointer;
      font-weight: bold;
      border-radius: 5px;
    }
    #timer {
      position: fixed;
      top: 10px;
      left: 50%;
      transform: translateX(-50%);
      font-size: 2em;
      font-weight: bold;
      color: #00ff88;
      z-index: 1100;
    }
  </style>
</head>
<body>

<div id="timer">5:00</div>

<nav>
  <ul style="display:flex; gap:10px; list-style:none; padding:10px; background:#222;">
    <li><a href="index.php" style="color:#00ff88; text-decoration:none;">Startpagina</a></li>
    <li><a href="room_1.php" style="color:#00ff88; text-decoration:none;">Kamer 1</a></li>
    <?php if (isset($_SESSION["kamer_2_toegang"])): ?>
      <li><a href="room_2.php" style="color:#00ff88; text-decoration:none;">Kamer 2</a></li>
    <?php endif; ?>
  </ul>
</nav>

<div id="question-container">
  <?php foreach ($questions as $index => $q) : ?>
    <div 
      class="box box<?php echo $index + 1; ?>" 
      data-index="<?php echo $index; ?>"
      data-question="<?php echo htmlspecialchars($q['question']); ?>"
      data-answer="<?php echo htmlspecialchars(strtolower($q['answer'])); ?>"
    >
      Vraag <?php echo $index + 1; ?>
    </div>
  <?php endforeach; ?>
</div>

<div id="overlay"></div>

<div id="modal">
  <h2>Escape Room Vraag</h2>
  <p id="question"></p>
  <input type="text" id="answer" placeholder="Typ je antwoord" autocomplete="off" />
  <button id="submit">Verzenden</button>
  <p id="feedback"></p>
  <button id="close">Sluit</button>
</div>

<script>
  let timerDuration = 5 * 60; // 5 minuten
  const timerDisplay = document.getElementById("timer");
  let answeredBoxes = 0;

  const boxes = document.querySelectorAll(".box");
  const modal = document.getElementById("modal");
  const overlay = document.getElementById("overlay");
  const questionEl = document.getElementById("question");
  const answerInput = document.getElementById("answer");
  const feedback = document.getElementById("feedback");
  const submitBtn = document.getElementById("submit");
  const closeBtn = document.getElementById("close");

  function startTimer() {
    const interval = setInterval(() => {
      const minutes = Math.floor(timerDuration / 60);
      const seconds = timerDuration % 60;
      timerDisplay.textContent = `${minutes}:${seconds < 10 ? "0" + seconds : seconds}`;
      timerDuration--;
      if (timerDuration < 0) {
        clearInterval(interval);
        alert("De tijd is om!");
        // Optioneel: redirect of blokkeren
      }
    }, 1000);
  }

  function openModal(index) {
    const box = boxes[index];
    if (box.style.display === "none") return; // al opgelost, niet openen
    questionEl.textContent = box.dataset.question;
    modal.dataset.correctAnswer = box.dataset.answer.toLowerCase();
    modal.dataset.index = index;
    answerInput.value = "";
    feedback.textContent = "";
    overlay.style.display = "flex";
    modal.style.display = "flex";
    answerInput.focus();
  }

  function closeModal() {
    modal.style.display = "none";
    overlay.style.display = "none";
  }

  function checkAnswer() {
    const userAnswer = answerInput.value.trim().toLowerCase();
    const correctAnswer = modal.dataset.correctAnswer;
    const index = parseInt(modal.dataset.index);
    if (userAnswer === correctAnswer) {
      feedback.textContent = "✅ Correct!";
      boxes[index].style.display = "none";
      answeredBoxes++;
      closeModal();
      if (answeredBoxes === 3) {
        // Zet hier evt sessievariabele als toegang
        window.location.href = "room_2.php";
      }
    } else {
      feedback.textContent = "❌ Helaas, probeer opnieuw.";
    }
  }

  boxes.forEach((box, i) => {
    box.addEventListener("click", () => openModal(i));
  });

  submitBtn.addEventListener("click", checkAnswer);
  closeBtn.addEventListener("click", closeModal);
  overlay.addEventListener("click", closeModal);

  window.onload = startTimer;
</script>

</body>
</html>