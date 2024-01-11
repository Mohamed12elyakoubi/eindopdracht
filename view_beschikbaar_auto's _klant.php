<?php
include 'db.php';
$conn = new Database();
$beschikbareAuto = $conn->getBeschikbareAuto();
$carCount = 0;

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

<body>
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
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="currentColor" class="bi bi-power" id="logoutBtn" style="margin-top: 350px; margin-left:70px" color="red" viewBox="0 0 16 16">
                    <path d="M7.5 1v7h1V1z" />
                    <path d="M3 8.812a4.999 4.999 0 0 1 2.578-4.375l-.485-.874A6 6 0 1 0 11 3.616l-.501.865A5 5 0 1 1 3 8.812" />
                </svg>
            </ul>
        </nav>
    </header>

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
            <p>Kenteken: <?php echo $carData['Kenteken']; ?></p>
            <p>Kilometerstand: <?php echo $carData['kmafstand']; ?> km</p>
            <p>Kleur: <?php echo $carData['Color']; ?></p>
            <p>Transmissie: <?php echo $carData['Transmissie']; ?></p>
            <p>Prijs: € <?php echo $carData['Prijs']; ?> per dag</p>
            <img src="<?= $carData['imagename'] ?>" />
            <br>
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
    </script>

</body>
</html>
