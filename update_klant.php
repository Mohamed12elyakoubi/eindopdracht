<?php
session_start();
include('db.php');
$conn = new Database();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_out.php");
    exit();
}
if (isset($_GET['id'])) {
    $klantID = $_GET['id'];
    $klantData = $conn->getUser($klantID);

    if ($klantData) {
        $klant_naam = $klantData['Klant_naam'];
        $klant_achternaam = $klantData['klant_achternaam'];
        $birthday = $klantData['birthday'];
        $adres = $klantData['Adres'];
        $rijbewijsnummer = $klantData['Rijbewijsnummer'];
        $telefoonnummer = $klantData['Telefoonnummer'];
        $email = $klantData['email'];
        $wachtwoord = $klantData['password'];
    }
    try {
         if ($_SERVER['REQUEST_METHOD'] == 'POST') {
             $hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
             $conn->editklant($_POST['name'], $_POST['lastname'], $_POST['birthday'],$_POST['adres'],$_POST['rijbewijs'],$_POST['tele'], $_POST['email'],$hash, $_GET['id']);
             echo '<div class="message" style="text-align: center; font-size:30px; color: green;"  onclick="redirectToIndex();">' . "User is succesvol geupdate" . '</div>';
            }
     } catch (Exception $e) {
         echo "Error: " . $e->getMessage();
       }

    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Klant</title>
    <link rel="stylesheet" href="./css/update.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <form method="POST" class="update">
        <h2>Klant Bewerken</h2>
        <input type="text" id="voornaam" name="name" placeholder="Voornaam" value="<?php echo $klant_naam; ?>" required><br />
        <input type="text" id="achternaam" name="lastname" placeholder="Achternaam" value="<?php echo $klant_achternaam; ?>" required><br />
        <label for="dateInput">Geboortedatum</label> <br>
        <input type="date" id="dateInput" name="birthday" value="<?php echo $birthday; ?>" required="required" min="1900-01-01" max="2007-01-09"> <br>
        <input type="text" id="adres" name="adres" placeholder="Adres" value="<?php echo $adres; ?>" required><br />
        <input type="text" id="rijbewijs" name="rijbewijs" placeholder="Rijbewijsnummer" value="<?php echo $rijbewijsnummer; ?>" required><br />
        <input type="tel" id="tele" name="tele" placeholder="Telefoonnummer" value="<?php echo $telefoonnummer; ?>" required><br />
        <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" required> <br>
        <input type="password" name="pass" id="pass" placeholder="Wachtwoord" value="<?php echo $wachtwoord; ?>" required> <br>
        <button type="submit">Bijwerken</button>
    </form>
</body>

</html>