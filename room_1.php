<?php

require_once('./dbcon.php');

try {
  $stmt = $db_connection->query("SELECT * FROM questions WHERE roomId = 1");
  $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Databasefout: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Escape Room 1</title>
  <link rel="stylesheet" href="style.css">
  <style>body {
      background-color: #0b0b0b;
      background-image: url("afbeeldingen/room-1.jpg");
      background-size: cover;
      color: #00ff88;
      font-family: 'Arial', sans-serif;
      text-align: center;
      margin: 0;
      padding-top: 100px;
    }</style>
</head>
<body onload="startTimer()">
  <div id="timer" style="position: absolute; top: 20px; right: 20px; font-size: 2em; font-weight: bold; color: #00ff88;">
  5:00
</div>
      <?php session_start(); ?>
      <?php if (isset($_SESSION["kamer_2_toegang"])): ?>
        <li><a href="room_2.php">Kamer 2</a></li>
      <?php endif; ?>
    </ul>
  </nav>

  <div class="container">
    <?php foreach ($questions as $index => $question) : ?>
      <div class="box box<?php echo $index + 1; ?>" onclick="openModal(<?php echo $index; ?>)"
        data-index="<?php echo $index; ?>" data-question="<?php echo htmlspecialchars($question['question']); ?>"
        data-answer="<?php echo htmlspecialchars($question['answer']); ?>">
        Box <?php echo $index + 1; ?>
      </div>
    <?php endforeach; ?>
  </div>

  <section class="overlay" id="overlay" onclick="closeModal()"></section>

  <section class="modal" id="modal">
    <h2>Escape Room Vraag</h2>
    <p id="question"></p>
    <input type="text" id="answer" placeholder="Typ je antwoord">
    <button onclick="checkAnswer()">Verzenden</button>
    <p id="feedback"></p>
  </section>

  <script src="app.js"></script>
  <script src="timer.js"></script>
  <script>
  function doorgaanNaarKamer2() {
    window.location.href = "room_2.php";
  }
</script>

</body>
