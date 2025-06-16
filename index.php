<?php
session_start();

// Controleer of de gebruiker is ingelogd
if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    // Als niet ingelogd, stuur door naar login.php
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Escape Room</title>
  <link rel="stylesheet" href="style.css" />
</head>
<script src="timer.js" defer></script>
<div id="timer" style="position: fixed; top: 20px; right: 20px; font-size: 24px; color: red; z-index: 9999;"></div>
<body>
<nav>
  <ul>
    <li><a href="index.php">Startpagina</a></li>
    <li><a href="room_1.php">Kamer 1</a></li>
    <li><a href="room_2.php">Kamer 2</a></li>
  </ul>
</nav>
<h1>Welkom bij Vault 666: Energy Contained</h1>
<button><a href="room_1.php">Klik hier om te beginnen!</a></button>
</body>
</html>
