<?php
include('db.php');
$conn = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn->register($_POST['name'], $_POST['lastname'], $_POST['birthday'], $_POST['adres'], $_POST['rijbewijs'], $_POST['tele'], $_POST['email'], $_POST['pass']);
    } catch (Exception $e) {
        echo $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
    <link rel="stylesheet" href="./css/add.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <div class="terug">
        <button type="button" id="back" class="btn btn-success"><a href="adminpanel.php"> Terug naar Medewerkers Portaal</a></button>
    </div>
    <main>
        <form method="POST" class="register">
            <h2>Klant toevoegen</h2>
            <input type="text" id="voornaam" name="name" placeholder="Voornaam" required><br />
            <input type="text" id="achternaam" name="lastname" placeholder="Achternaam" required><br />
            <label for="dateInput">Geboortedatum</label> <br>
            <input type="date" id="dateInput" name="birthday" autofocus required="required" min="1900-01-01" max="2007-01-09"> <br>
            <input type="text" id="adres" name="adres" placeholder="Adres" required><br />
            <input type="text" id="rijbewijs" name="rijbewijs" placeholder="Rijbewijsnummer" max='10000000000' required><br />
            <input type="tel" id="tele" name="tele" placeholder="Telefoonnummer" required><br />
            <input type="email" name="email" id="email" placeholder="Email" required> <br>
            <input type="password" name="pass" id="pass" placeholder="Wachtwoord" required> <br>
            <button type="submit">Toevoegen</button>
        </form>
    </main>
</body>

</html>