<?php
session_start();
include 'dbcon.php'; // Verbind met de database

// Controleer of het formulier is ingediend
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Zoek de gebruiker in de database
    $stmt = $conn->prepare("SELECT id, naam, wachtwoord, admin FROM gebruikers WHERE naam = :naam");
    $stmt->bindParam(':naam', $naam);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // Controleer of wachtwoord overeenkomt
        if (password_verify($wachtwoord, $user['wachtwoord'])) {
            // Inloggegevens zijn correct, initialiseer sessie
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['naam'] = $user['naam'];
            $_SESSION['admin'] = $user['admin'];

            // Redirect naar de hoofdpagina
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Ongeldige gebruikersnaam of wachtwoord.";
        }
    } else {
        $error_message = "Ongeldige gebruikersnaam of wachtwoord.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Log in</h2>

    <?php if (isset($error_message)) { echo "<p>$error_message</p>"; } ?>

    <form method="post" action="">
        <label for="naam">Naam:</label><br>
        <input type="text" id="naam" name="naam" required><br>

        <label for="wachtwoord">Wachtwoord:</label><br>
        <input type="password" id="wachtwoord" name="wachtwoord" required><br><br>

        <input type="submit" value="Inloggen">
    </form>

    <form action="register.php">
        <input type="submit" value="Nog niet geregistreerd? Registreer hier!">
    </form>
</body>
</html>