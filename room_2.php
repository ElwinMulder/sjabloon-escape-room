<?php
session_start();
if (!isset($_SESSION["kamer_2_toegang"])) {
  header("Location: room_1.php");
  exit;
}

require_once('./dbcon.php');

try {
  $stmt = $db_connection->query("SELECT * FROM questions WHERE roomId = 2");
  $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
  die("Databasefout: " . $e->getMessage());
}
?>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Escape Room 2</title>
  <link rel="stylesheet" href="style.css">
  <style><style>body {
      background-color: #0b0b0b;
      background-image: url("afbeeldingen/room-2.jpg");
      background-size: cover;
      color: #00ff88;
      font-family: 'Arial', sans-serif;
      text-align: center;
      margin: 0;
      padding-top: 100px;
    }</style></style>
</head>
<script src="js/timer.js"></script>

<body>
<body onload="resetAndStartTimer()">


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

</body>

</html>