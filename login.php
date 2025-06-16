<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    $users = file("users.txt", FILE_IGNORE_NEW_LINES);

    foreach ($users as $user) {
        list($savedUser, $savedHash) = explode(":", $user);
        if ($savedUser === $username && password_verify($password, $savedHash)) {
            $_SESSION["username"] = $username;
            $_SESSION["logged_in"] = true; 
            header("Location: index.php");
            exit;
        }
    }

    $error = "Ongeldige inloggegevens.";
}
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <title>Inloggen</title>
    <style>
        body {
    margin: 0;
    padding: 0;
    font-family: Arial, sans-serif;
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background-image: url(afbeeldingen/loading.png);
    background-size: cover;
    background-position: center;
    position: relative;
}

        .login-container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
        }

        input[type="text"], input[type="password"] {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        input[type="submit"] {
            width: 95%;
            padding: 10px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }

        .success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Inloggen</h2>
        <?php if (isset($_GET['success'])): ?>
            <p class="success">Registratie succesvol! Log nu in.</p>
        <?php endif; ?>

        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>

        <form method="post">
            <input type="text" name="username" placeholder="Gebruikersnaam" required><br>
            <input type="password" name="password" placeholder="Wachtwoord" required><br>
            <input type="submit" value="Inloggen">
        </form>
        <p>Nog geen account? <a href="register.php">Registreer hier</a></p>
    </div>
</body>
</html>


