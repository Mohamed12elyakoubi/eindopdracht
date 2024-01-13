<?php
session_start();
include('db.php');
$conn = new Database();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: uitloggen.php");
    exit();
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $startVerhuurdatum = $_POST["StartVerhuurdatum"];
    $eindVerhuurdatum = $_POST["EindeVerhuurdatum"];
    $autoID = $_POST["autoID"];
    $klantID = $_POST["klantID"];
    $prijs = $conn->getPricePerDay($autoID);

    if ($prijs !== null) {
        $aantalDagen = (strtotime($eindVerhuurdatum) - strtotime($startVerhuurdatum)) / (60 * 60 * 24);
        $kosten = $prijs * $aantalDagen;

        $gereserveerdeAutoIDs = $conn->getGereserveerdeAutoIDsVoorDatumBereik($startVerhuurdatum, $eindVerhuurdatum);
        if (!in_array($autoID, $gereserveerdeAutoIDs)) {
            if ($conn->addReservation($startVerhuurdatum, $eindVerhuurdatum, $autoID, $klantID, $kosten)) {
                echo "<div class='success-message'>Reservering succesvol toegevoegd. Kosten: € {$kosten}</div>";
                echo "<div class='factuur-message'>Je wordt zo naar uw factuur gestuurd";
            } else {
                echo "<div class='error-message'>Er is een fout opgetreden bij het toevoegen van de reservering.</div>";
            }
        } else {
            echo "<div class='error-message'>De geselecteerde auto is niet beschikbaar voor de opgegeven periode.</div>";
        }
    } else {
        echo "<div class='error-message'>Fout bij het ophalen van de prijs van de auto.</div>";
    }}

?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verhuringen</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="./css/klant.css">

</head>
<header>
            <input type="checkbox" id="hamburger"/>
            <label for="hamburger" class="hamburger_btn">
                <span></span>
            </label>

            <ul class="hamburger_menu">
                <li> <a class="menu_item" href="adminpanel.php">Medewerkers Portaal</a></li>
                <li> <a class="menu_item" href="view_all_klanten.php">Klanten bekijken</a></li>
                <li> <a class="menu_item" href="view_all_cars.php">Auto's bekijken</a></li>
                <li> <a class="menu_item" href="view_all_medewerkers.php">Medewerkers bekijken</a></li>
            </ul>

    </header>

<body>
<div class="container">
        <div class="header">
            <h1>Auto verhuren</h1>
        </div>
        <div class="p-3 mb-2 bg-primary text-white">
    <form action="" method="post">
        <label for="klantID">Selecteer Klant ID:</label>
        <select name="klantID" required class="form-select form-select-sm">
            <option value="" disabled>Selecteer een Klant ID</option>
            <?php
            $klanten = $conn->getUser();
            foreach ($klanten as $klant) {
                echo "<option value='{$klant['KlantID']}'>{$klant['Klant_naam']} {$klant['klant_achternaam']} -{$klant['KlantID']}</option>";
            }
            ?>
        </select>

        <label for="autoID">Selecteer Auto:</label>
        <select name="autoID" required class="form-select form-select-sm">
            <option value="" disabled>Selecteer een auto</option>
            <?php
            $gereserveerdeAutoIDs = $conn->getGereserveerdeAutoIDsVoorDatumBereik($startVerhuurdatum, $eindVerhuurdatum);
            $autoResult = $conn->haalAlleBeschikbareAutosOp($gereserveerdeAutoIDs);

            foreach ($autoResult as $auto) {
                echo "<option value='{$auto['AutoID']}'>{$auto['Name']}</option>";
            }
            ?>
        </select>

        <label for="StartVerhuurdatum">Start Verhuurdatum:</label>
        <input type="date" name="StartVerhuurdatum" id="startDatum" required>

        <label for="EindeVerhuurdatum">Einde Verhuurdatum:</label>
        <input type="date" name="EindeVerhuurdatum" id="eindDatum" required>

        <button type="submit" class="btn btn-warning">Reserveer</button><br>
        <td><a href='add_klant.php' class='btn btn-success'>Klant Toevoegen</a></td>
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
