<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["username"]);
    $password = trim($_POST["password"]);

    if (!empty($username) && !empty($password)) {
        if (!file_exists("users.txt")) {
            file_put_contents("users.txt", ""); // Maak bestand aan als het nog niet bestaat
        }
        $users = file("users.txt", FILE_IGNORE_NEW_LINES);

        foreach ($users as $user) {
            list($savedUser, ) = explode(":", $user);
            if ($savedUser === $username) {
                $error = "Gebruiker bestaat al.";
                break;
            }
        }

        if (empty($error)) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            file_put_contents("users.txt", "$username:$hashed\n", FILE_APPEND);
            header("Location: login.php?success=1");
            exit;
        }
    } else {
        $error = "Vul alle velden in.";
    }
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8" />
    <title>Registreren</title>
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
        .register-container {
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
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #218838;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        a {
            color: #007bff;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Registreren</h2>
        <?php if (!empty($error)) echo "<p class='error'>$error</p>"; ?>
        <form method="post">
            <input type="text" name="username" placeholder="Gebruikersnaam" required><br />
            <input type="password" name="password" placeholder="Wachtwoord" required><br />
            <input type="submit" value="Registreren" />
        </form>
        <p>Al een account? <a href="login.php">Log hier in</a></p>
    </div>
</body>
</html>


