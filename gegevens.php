<?php
include('db.php');
$conn = new Database();

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: inlogpagina.php");
    exit();
}
$klantID1 = $_SESSION['KlantID'];
$reservedCar = $conn->gereserveerdeauto($klantID1);

$klantID = $_SESSION['klantID'];
$userData = $conn->getUser($klantID);
if ($userData) {
    $klantNaam = $userData['Klant_naam'] . ' ' . $userData['klant_achternaam'];
    $geboortedatum = $userData['birthday'];
    $adres = $userData['Adres'];
    $rijbewijs = $userData['Rijbewijsnummer'];
    $telefoon = $userData['Telefoonnummer'];
    $email = $userData['email'];
    $aanmaakdatum = $userData['AanmaakDatum'];
} else {
    $klantNaam = "Gebruiker";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gegevens</title>
    <link rel="stylesheet" href="./css/klant.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">



</head>

<body style="background: rgb(110,253,178);
background: radial-gradient(circle, rgba(110,253,178,1) 0%, rgba(110,184,227,0.6867997198879552) 36%, rgba(133,181,218,1) 50%, rgba(95,81,251,0.8772759103641457) 100%);"
>
    <header>
        <nav>
            <input type="checkbox" id="hamburger" />
            <label for="hamburger" class="hamburger_btn">
                <span></span>
            </label>

            <ul class="hamburger_menu">
            <a href="klant_panel.php"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-bar-left" id="backtohome" style="margin-left:70px" color="green" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5" />
                </svg></a>
                <li> <a class="menu_item" href="gegevens.php">Gegevens</a></li>
                <li> <a class="menu_item" href="verhuring.php">Auto verhuren</a></li>
                <li> <a class="menu_item" href="auto's.php">Auto's</a></li>
                <li> <a class="menu_item" href="factuur.php">Factuur</a></li>
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-power" id="logoutBtn" style="margin-top: 250px; margin-left:70px" color="red" viewBox="0 0 16 16">
                    <path d="M7.5 1v7h1V1z" />
                    <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                </svg>
            </ul>
        </nav>
    </header>
    <h1> Welcome <?php echo $klantNaam; ?></h1>
    <h1> Uw Gegevens</h1>
    <div class="gegevens">
    <h2>Naam : <strong style="color:blue"><?php echo $klantNaam; ?></strong></h2>
    <h3>Geboortedatum :<strong style="color:blue"> <?php echo $geboortedatum; ?></strong></h3>
    <h3> Adres: <strong style="color:blue"><?php echo $adres; ?> </strong></h3>
    <h3> Rijbewijsnummer: <strong style="color:blue"><?php echo $rijbewijs; ?></strong></h3>
    <h3>Telefoonnummer:<strong style="color:blue"> 0<?php echo $telefoon; ?></strong> </h3>
    <h3>email: <strong style="color:blue"><?php echo $email; ?> </strong> </h3>
    <h3>AanmaakDatum: <strong style="color:blue"><?php echo $aanmaakdatum; ?> </strong></h3>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#logoutBtn").click(function() {
                var form = $('<form action="uitloggen.php" method="post"></form>');
                form.appendTo('body').submit();
            });
        });
    </script>
</body>

</html>