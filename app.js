
function openModal(index) {
  let box = document.querySelector(`.box[data-index='${index}']`);

  let questionText = box.dataset.question;
  let correctAnswer = box.dataset.answer;

  document.getElementById('question').innerText = questionText;

  document.getElementById('modal').dataset.answer = correctAnswer;

  document.getElementById('answer').value = '';

  document.getElementById('overlay').style.display = 'block';
  document.getElementById('modal').style.display = 'block';
}

function closeModal() {
  document.getElementById('overlay').style.display = 'none';
  document.getElementById('modal').style.display = 'none';
  
  document.getElementById('feedback').innerText = '';
}

function checkAnswer() {
  let userAnswer = document.getElementById('answer').value.trim();
  
  let correctAnswer = document.getElementById('modal').dataset.answer;
  
  let feedback = document.getElementById('feedback');

  if (userAnswer.toLowerCase() === correctAnswer.toLowerCase()) {
    feedback.innerText = 'Correct! Goed gedaan!';
    feedback.style.color = 'green';

    setTimeout(closeModal, 1000);
  } else {
    feedback.innerText = 'Fout, probeer opnieuw!';
    feedback.style.color = 'red';
  }
}
