<?php
session_start();
include('db.php');
$conn = new Database();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: uitloggen.php");
    exit();
}
if (isset($_GET['id'])) {
    $autoID = $_GET['id'];
    $cardata = $conn->getcar($autoID);
    if ($cardata) {
        $Name = $cardata['Name'];
        $prijs = $conn->getPricePerDay($autoID);
    }
}

$klantID = $_SESSION['klantID'];
$userData = $conn->getUser($klantID);
if ($userData) {
    $klantNaam = $userData['Klant_naam'] . ' ' . $userData['klant_achternaam'];
} else {
    $klantNaam = "Gebruiker";
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startVerhuurdatum = $_POST["StartVerhuurdatum"];
    $eindVerhuurdatum = $_POST["EindeVerhuurdatum"];
    $autoID = $_POST["autoID"];
    $klantID = $_SESSION['klantID'];
    $prijs = $conn->getPricePerDay($autoID);

    if ($prijs !== null) {
        $aantalDagen = (strtotime($eindVerhuurdatum) - strtotime($startVerhuurdatum)) / (60 * 60 * 24);
        $kosten = $prijs * $aantalDagen;

        // Controleer eerst of de auto beschikbaar is voor de opgegeven periode
        $gereserveerdeAutoIDs = $conn->getGereserveerdeAutoIDsVoorDatumBereik($startVerhuurdatum, $eindVerhuurdatum);
        if (!in_array($autoID, $gereserveerdeAutoIDs)) {
            // Auto is beschikbaar, voeg reservering toe
            if ($conn->addReservation($startVerhuurdatum, $eindVerhuurdatum, $autoID, $klantID, $kosten)) {
                echo "<div class='success-message'>Reservering succesvol toegevoegd. Kosten: € {$kosten}</div>";
            } else {
                echo "<div class='error-message'>Er is een fout opgetreden bij het toevoegen van de reservering.</div>";
            }
        } else {
            // Auto is niet beschikbaar
            echo "<div class='error-message'>De geselecteerde auto is niet beschikbaar voor de opgegeven periode.</div>";
        }
    } else {
        echo "<div class='error-message'>Fout bij het ophalen van de prijs van de auto.</div>";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verhuringen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="./css/klant.css">

</head>
<h1 > Welcome <?php echo $klantNaam; ?></h1>
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
                <li> <a class="menu_item" href="view_beschikbaar_auto's _klant.php">beschikbare Auto's</a></li>
                <li> <a class="menu_item" href="auto's.php">Auto's</a></li>
                <li> <a class="menu_item" href="factuur.php">Factuur</a></li>
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-power" id="logoutBtn" style="margin-top: 250px; margin-left:70px" color="red" viewBox="0 0 16 16">
                    <path d="M7.5 1v7h1V1z" />
                    <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                </svg>
            </ul>
        </nav>
    </header>

<body>
<div class="container">
        <div class="header">
            <h1>Auto verhuren</h1>
        </div>
        <div class="p-3 mb-2 bg-primary text-white">
            <form action="" method="post">
                <input type="date" name="StartVerhuurdatum" id="startDatum" required>
                <input type="date" name="EindeVerhuurdatum" id="eindDatum" required>

                <input type="hidden" id="prijs" value="<?= $prijs ?>">

                <select name="autoID" required class="form-select form-select-sm">
                    <option value="" disabled>Selecteer een auto</option>
                    <?php
                    // Haal gereserveerde auto-ID's op voor het geselecteerde verhuurperiode
                    $gereserveerdeAutoIDs = $conn->getGereserveerdeAutoIDsVoorDatumBereik($startVerhuurdatum, $eindVerhuurdatum);
                    // Haal beschikbare auto's op
                    $autoResult = $conn->haalAlleBeschikbareAutosOp($gereserveerdeAutoIDs);

                    foreach ($autoResult as $auto) {
                        echo "<option value='{$auto['AutoID']}'>
                        <strong>{$auto['Name']}  <br>- <strong>Prijs:</strong> € {$auto['Prijs']} per dag
                              </option>";
                    }
                    ?>
                </select>

                <button type="submit" class="btn btn-warning">Reserveer</button>
            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#logoutBtn").click(function() {
                var form = $('<form action="uitloggen.php" method="post"></form>');
                form.appendTo('body').submit();
            });
        });

    document.addEventListener("DOMContentLoaded", function() {
        var successMessage = document.querySelector('.success-message');
        var errorMessage = document.querySelector('.error-message');

        setTimeout(function() {
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 5000);
    });
    </script>
</body>

</html>