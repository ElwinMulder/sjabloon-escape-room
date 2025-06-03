let correctAnswers = new Set();
let currentQuestionIndex = null;

function openModal(index) {
  const box = document.querySelector(`.box${index + 1}`);
  const question = box.getAttribute('data-question');
  const answer = box.getAttribute('data-answer');

  currentQuestionIndex = index;
  document.getElementById('question').textContent = question;
  document.getElementById('answer').value = '';
  document.getElementById('feedback').textContent = '';
  document.getElementById('modal').style.display = 'block';

  // Sla het juiste antwoord op in de modal zelf
  document.getElementById('modal').dataset.correctAnswer = answer.toLowerCase().trim();
}

function closeModal() {
  document.getElementById('modal').style.display = 'none';
}

function checkAnswer() {
  const userAnswer = document.getElementById('answer').value.toLowerCase().trim();
  const correctAnswer = document.getElementById('modal').dataset.correctAnswer;

  if (userAnswer === correctAnswer) {
    document.getElementById('feedback').textContent = "✅ Goed beantwoord!";
    correctAnswers.add(currentQuestionIndex); // Zorgt dat elk vraagindex maar één keer telt

    setTimeout(() => {
      closeModal();

      if (correctAnswers.size === 3) {
        // Alle 3 goed beantwoord → doorgaan naar kamer 2
        fetch('unlock_room_2.php').then(() => {
          window.location.href = 'room_2.php';
        });
      }
    }, 1000);

  } else {
    document.getElementById('feedback').textContent = "❌ Fout antwoord, probeer het opnieuw.";
  }
}
