<?php
session_start();
include('db.php');
$conn = new Database();
$data = $conn->getAllCars();

 ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto Overzicht</title>
    <link rel="stylesheet" href="./css/View.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>

<body>
    <header>
        <input type="checkbox" id="hamburger" />
        <label for="hamburger" class="hamburger_btn">
            <span></span>
        </label>

        <ul class="hamburger_menu">
            <li> <a class="menu_item" href="adminpanel.php">Medewerkers Portaal</a></li>
            <li> <a class="menu_item" href="view_all_klanten.php">Klanten bekijken</a></li>
            <li> <a class="menu_item" href="view_all_medewerkers.php">Medewerkers bekijken</a></li>
            <li> <a class="menu_item" href="view_all_verhuringen.php">Verhuringen bekijken</a></li>
        </ul>

    </header>
    <table class="table">
        <thead>
            <tr>
                <th>AutoID</th>
                <th>Naam</th>
                <th>Merk</th>
                <th>Model</th>
                <th>Jaar</th>
                <th>Kenteken</th>
                <th>Km-afstand</th>
                <th>Color</th>
                <th>Transmissie</th>
                <th>Brandstof</th>
                <th>Prijs</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                foreach ($data as $da) {
                    echo "<td>" . $da['AutoID'] . "</td>";
                    echo "<td>" . $da['Name'] . "</td>";
                    echo "<td>" . $da['Merk'] . "</td>";
                    echo "<td>" . $da['Model'] . "</td>";
                    echo "<td>" . $da['Jaar'] . "</td>";
                    echo "<td>" . $da['Kenteken'] . "</td>";
                    echo "<td>" . $da['kmafstand'] . "</td>";
                    echo "<td>" . $da['Color'] . "</td>";
                    echo "<td>" . $da['Transmissie'] . "</td>";
                    echo "<td>" . $da['Brandstof'] . "</td>";
                    echo "<td>" . $da['Prijs'] . "</td>";
                    echo "<td><a href='update_cars.php?id={$da['AutoID']}' class='btn btn-info'>Bewerken</a></td>";
                    echo "<td><a href='addcar.php'class='btn btn-success'>Toevoegen</a></td>";
                    echo "<td><a href='delete_car.php?id={$da['AutoID']}' class='btn btn-danger'>Verwijderen</a></td>";

                ?>
            </tr>
        <?php  } ?>
        </tbody>
    </table>

</body>

</html>