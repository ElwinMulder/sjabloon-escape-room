<?php
include 'dbcon.php'; // Verbind met de database

// Verwerken van de registratiegegevens
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $naam = $_POST['naam'];
    $wachtwoord = $_POST['wachtwoord'];

    // Controleer of de gebruikersnaam al bestaat
    $stmt = $conn->prepare("SELECT id FROM gebruikers WHERE naam = :naam");
    $stmt->bindParam(':naam', $naam);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        echo "Deze gebruikersnaam bestaat al. Kies een andere.";
    } else {
        // Gegevens invoegen in database
        $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT); // Wachtwoord hashen
        $sql = "INSERT INTO gebruikers (naam, wachtwoord) VALUES ('$naam', '$hashed_password')";

        try {
            $conn->exec($sql);
            echo "Registratie succesvol!";
        } catch (PDOException $e) {
            echo "Fout bij registratie: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registratiepagina</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h2>Registreer</h2>

    <form method="post" action="">
        <label for="naam">Naam:</label><br>
        <input type="text" id="naam" name="naam" required><br>

        <label for="wachtwoord">Wachtwoord:</label><br>
        <input type="password" id="wachtwoord" name="wachtwoord" required><br><br>

        <input type="submit" value="Registreren">
    </form>

    <form action="login.php">
        <input type="submit" value="Log hier in als u een account heeft">
    </form>
</body>
</html>
