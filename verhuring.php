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
        $klantHeeftReservering = $conn->heeftKlantReservering($klantID);
        if (!$klantHeeftReservering) {

            $gereserveerdeAutoIDs = $conn->getGereserveerdeAutoIDsVoorDatumBereik($startVerhuurdatum, $eindVerhuurdatum);
            if (!in_array($autoID, $gereserveerdeAutoIDs)) {
                if ($conn->addReservation($startVerhuurdatum, $eindVerhuurdatum, $autoID, $klantID, $kosten)) {
                    echo "<div class='success-message'>Reservering succesvol toegevoegd. Kosten: € {$kosten} <br>
                     Uw factuur gemaakt, U wordt zo gestuurd </div>";
                    echo '<script>
                setTimeout(function(){
                    window.location.href = "factuur.php";
                }, 6000);
            </script>';
                } else {
                    echo "<div class='error-message'>Er is een fout opgetreden bij het toevoegen van de reservering.</div>";
                }
            } else {
                echo "<div class='error-message'>De geselecteerde auto is niet beschikbaar voor de opgegeven periode.</div>";
            }
        }else{
                echo "<div class='error-message'>U heeft al een actieve reservering. U kunt niet nog een auto reserveren.</div>";

            }
        } else {
            echo "<div class='error-message'>Fout bij het ophalen van de prijs van de auto.</div>";
        }
    }

$beschikbareAuto = $conn->getBeschikbareAuto();
$carCount = 0;
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
<body style="background: rgb(180,180,180);
background: linear-gradient(90deg, rgba(180,180,180,0.8464635854341737) 0%, rgba(255,255,255,0) 14%, rgba(255,252,252,0.34226190476190477) 36%, rgba(255,255,255,0.8016456582633054) 82%, rgba(180,180,180,1) 97%);">
    
<h1> Welcome <?php echo $klantNaam; ?></h1>
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

    <div class="container" id="reserveer-sectie">
        <div class="header">
            <h1>Auto verhuren</h1>
        </div>
        <div class="p-3 mb-2 bg-primary text-white">
            <form action="" method="post">
                <input type="date" name="StartVerhuurdatum" id="startDatum" required>
                <input type="date" name="EindeVerhuurdatum" id="eindDatum" required>

                <input type="hidden" id="prijs" value="<?= $prijs ?>">

                <input type="hidden" name="autoID" id="autoID" required readonly>
                <input type="text" id="selectedAutoName" name="selectedAutoName" value="Geen auto geselcteerd" readonly>
                <button type="submit" class="btn btn-warning">Reserveer</button>



            </form>
        </div>
    </div>
    <h1>Beschikbare Auto's</h1>
    <?php
    foreach ($beschikbareAuto as $carData) {
        if ($carCount % 4 === 0) {
            echo '<div class="row">';
        }

    ?>
        <div class="cars_b">
            <h2><?php echo $carData['Name']; ?></h2>
            <p>Merk: <?php echo $carData['Merk']; ?></p>
            <p>Model: <?php echo $carData['Model']; ?></p>
            <p>Jaar: <?php echo $carData['Jaar']; ?></p>
            <p>Kilometerstand: <?php echo $carData['kmafstand']; ?> km</p>
            <p>Kleur: <?php echo $carData['Color']; ?></p>
            <p>Transmissie: <?php echo $carData['Transmissie']; ?></p>
            <p>Prijs: € <?php echo $carData['Prijs']; ?> per dag</p>
            <img src="<?= $carData['imagename'] ?>" />
            <br>
            <div class="kenteken2">
                <div class="inset2">
                    <div class="blue2"></div>
                    <input type="text" value="<?php echo $carData['Kenteken']; ?>" disabled />
                </div>
            </div>
            <br>
            <button class="reserve-button btn btn-success" data-auto-id="<?php echo $carData['AutoID']; ?>" data-auto-name="<?php echo $carData['Name']; ?>">
                Reserveer nu
            </button>
        </div>

    <?php
        $carCount++;
        if ($carCount % 4 === 0) {
            echo '<br></div>';
        }
    }

    if ($carCount % 4 !== 0) {
        echo '</div>';
    }
    ?>
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
        $(document).ready(function() {
            $(".reserve-button").click(function() {
                var autoID = $(this).data('auto-id');
                var autoName = $(this).data('auto-name');
                $("#selectedAutoName").val(autoName);

                $("#autoID").val(autoID);
                $('html, body').animate({
                    scrollTop: $("#reserveer-sectie").offset().top
                }, 1000);
            });
            console.log("Geselecteerde auto: ID=" + autoID + ", Naam=" + autoName);

        });
    </script>
</body>

</html>