<?php
include 'db.php';
$conn = new Database();
$carsData = $conn->getAllCars();
$carCount = 0;
foreach ($carsData as $carData) {

    if ($carCount % 4 === 0) {
        echo '<div class="row">';
    }
?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Auto Overzicht</title>
        <link rel="stylesheet" href="./css/auto.css">
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

    </head>
    <body>
        <nav>
            <a href="home.php"><img src="img/logoCar.png" alt="car"></a>
            <a href="home.php">Home</a>
            <a href="register.php">Register</a>
            <a href="inlogpagina.php">login</a>
            <a href="auto.php"><i class="bi bi-car-front"></i></a>
                </nav>
        <div class="cars">
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
        echo '</div>';
    }
}
if ($carCount % 4 !== 0) {
    echo '</div>';
}
    ?>
    </body>

    </html>