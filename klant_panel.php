<?php

include('db.php');
$conn = new Database();
$carCount = 0;

session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: uitloggen.php");
    exit();
}

$klantID = $_SESSION['klantID'];
$reservedCars = $conn->gereserveerdeauto($klantID);


$userData = $conn->getUser($klantID);
if ($userData) {
} else {
    $klantNaam = "Gebruiker";
}

$klantID = $_SESSION['klantID'];
$userData = $conn->getUser($klantID);
$klantNaam = ($userData) ? $userData['Klant_naam'] . ' ' . $userData['klant_achternaam'] : "Gebruiker";

$klantID = $_SESSION['klantID'];
$data = $conn->verhuring($klantID);
$eindVerhuurdatum = new DateTime($data['EindVerhuurdatum']);
$huidigeDatum = new DateTime();
$resterendeDagen = $huidigeDatum->diff($eindVerhuurdatum)->format("%a");

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>hamburger</title>
    <link rel="stylesheet" href="./css/klant.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

</head>

<body>
    <h1> Welcome <?php echo $klantNaam; ?></h1>
    <header>
        <nav>
            <input type="checkbox" id="hamburger" />
            <label for="hamburger" class="hamburger_btn">
                <span></span>
            </label>

            <ul class="hamburger_menu">
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

    <h1>Uw gereserveerde auto</h1>
    <?php if ($reservedCars) : ?>
        <div class="car-reserved">
        <h2><?php echo $reservedCars['Name']; ?></h2>
            <p><strong>Merk:</strong> <?php echo $reservedCars['Merk']; ?></p>
            <p><strong>Model:</strong> <?php echo $reservedCars['Model']; ?></p>
            <p><strong>Jaar:</strong> <?php echo $reservedCars['Jaar']; ?></p>
            <p><strong>Kilometerstand:</strong> <?php echo $reservedCars['kmafstand']; ?> km</p>
            <p><strong>Kleur:</strong> <?php echo $reservedCars['Color']; ?></p>
            <p><strong>Transmissie:</strong> <?php echo $reservedCars['Transmissie']; ?></p>
            <p><strong>Prijs: €</strong> <?php echo $reservedCars['Prijs']; ?> per dag</p>
            <img src="<?= $reservedCars['imagename'] ?>" />
            <div class="kenteken2" style="margin-left: 45px;">
                <div class="inset2">
                    <div class="blue2"></div>
                    <input type="text" value="<?php echo $reservedCars['Kenteken']; ?>" disabled />
                </div>
            </div>
           <strong> <p>Resterende dagen: <?php echo $resterendeDagen; ?> dagen</p></strong>
            <br>
            
        </div>
    <?php else : ?>
        <h2 style="display: flex; justify-content:center; ">Geen auto gevonden</h2>
    <?php endif; ?>
    
    <?php
    $carCount++;
    if ($carCount % 4 === 0) {
        echo '</div>';
    }

    if ($carCount % 4 !== 0) {
        echo '</div>';
    }
    ?>
    <br>

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