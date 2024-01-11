<?php
include('db.php');
$conn = new Database();
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if ($conn->gebruikte_emails($_POST['email'])) {
            $error_message = 'Email is gebruikt ,kies een andere';
        } else {
            $conn->register($_POST['name'], $_POST['lastname'], $_POST['birthday'], $_POST['adres'], $_POST['rijbewijs'], $_POST['tele'], $_POST['email'], $_POST['pass']);
        }
    } catch (Exception $e) {
        $error_message = 'Er is iets misgegaan tijdens de registratie.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="./css/register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <img src="https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/46f37945885079.584030cfd603d.gif" alt="background" class="background-img">
    <nav>
        <a href="home.php"><img src="img/logoCar.png" alt="car"></a>
        <a href="home.php">Home</a>
        <a href="register.php">Register</a>
        <a href="inlogpagina.php">login</a>
        <a href="auto.php"><i class="bi bi-car-front"></i></a>
    </nav>

    <main>
        <form method="POST" class="register">
            <h2>Registreren</h2>

            <?php if (!empty($error_message)) : ?>
                <div id="error-message" class="error-message" style="text-align: center; font-size: 25px; color: red;">
                    <?= htmlspecialchars($error_message) ?>
                </div>
            <?php endif; ?>
            <input type="text" id="voornaam" name="name" placeholder="Voornaam" required><br />
            <input type="text" id="achternaam" name="lastname" placeholder="Achternaam" required><br />
            <label for="dateInput">Geboortedatum</label> <br>
            <input type="date" id="dateInput" name="birthday" autofocus required="required" min="1900-01-01" max="2007-01-09"> <br>
            <input type="text" id="adres" name="adres" placeholder="Adres" required><br />
            <input type="text" id="rijbewijs" name="rijbewijs" placeholder="Rijbewijsnummer" max='10000000000' required><br />
            <input type="tel" id="tele" name="tele" placeholder="Telefoonnummer" required><br />
            <input type="email" name="email" id="email" placeholder="Email" required> <br>
            <input type="password" name="pass" id="pass" placeholder="Wachtwoord" required> <br>
            <button type="submit">Register</button>
        </form>
    </main>
</body>

</html>
<script>
    <?php if (!empty($error_message)) : ?>
        setTimeout(function() {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        }, 5000);
    <?php endif; ?>
</script>