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

        <input type="checkbox" id="hamburger" />
        <label for="hamburger" class="hamburger_btn">
            <span></span>
        </label>

        <ul class="hamburger_menu">
            <li> <a class="menu_item" href="view_verhuurde_auto.php">Verhuurde Auto's</a></li>
            <li> <a class="menu_item" href="adminpanel.php">Medewerkers Portaal</a></li>
        </ul>

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
            <p>Kilometerstand: <?php echo $carData['kmafstand']; ?> km</p>
            <p>Kleur: <?php echo $carData['Color']; ?></p>
            <p>Transmissie: <?php echo $carData['Transmissie']; ?></p>
            <p>Prijs: € <?php echo $carData['Prijs']; ?> per dag</p>
            <img src="<?= $carData['imagename'] ?>" />
            <br>
            <div class="kenteken2" style="margin-left: 30px;">
                <div class="inset2">
                    <div class="blue2"></div>
                    <input type="text" value="<?php echo $carData['Kenteken']; ?>" disabled />
                </div>
            </div>
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