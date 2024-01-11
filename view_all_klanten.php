<?php
session_start();
include('db.php');
$conn = new Database();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_out.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View all users</title>
    <link rel="stylesheet" href="./css/View.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
    </head>
    <header>
            <input type="checkbox" id="hamburger"/>
            <label for="hamburger" class="hamburger_btn">
                <span></span>
            </label>

            <ul class="hamburger_menu">
                <li> <a class="menu_item" href="adminpanel.php">Medewerkers Portaal</a></li>
                <li> <a class="menu_item" href="view_all_cars.php">Auto's bekijken</a></li>
                <li> <a class="menu_item" href="view_all_medewerkers.php">Medewerkers bekijken</a></li>
                <li> <a class="menu_item" href="view_all_verhuringen.php">Verhuringen bekijken</a></li>
            </ul>

    </header>
    <body>
        <table class="table">
            <thead>
                <tr>
                    <th>KlantID</th>
                    <th>klant_naam</th>
                    <th>klant_achternaam</th>
                    <th>Geboortedatum</th>
                    <th>Adres</th>
                    <th>rijbewijsnummer</th>
                    <th>telefoonnummer</th>
                    <th>email</th>
                    <th>AanmaakDatum</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $data = $conn->getUser();
                    foreach ($data as $da) {
                        echo "<td>" . $da['KlantID'] . "</td>";
                        echo "<td>" . $da['Klant_naam'] . "</td>";
                        echo "<td>" . $da['klant_achternaam'] . "</td>";
                        echo "<td>" . $da['birthday'] . "</td>";
                        echo "<td>" . $da['Adres'] . "</td>";
                        echo "<td>" . $da['Rijbewijsnummer'] . "</td>";
                        echo "<td>" . $da['Telefoonnummer'] . "</td>";
                        echo "<td>" . $da['email'] . "</td>";
                        echo "<td>" . $da['AanmaakDatum'] . "</td>";
                        echo "<td><a href='update_klant.php?id={$da['KlantID']}' class='btn btn-info'>Bewerken</a></td>";
                        echo "<td><a href='add_klant.php' class='btn btn-success'>Toevoegen</a></td>";
                        echo "<td><a href='delete_klant.php?id={$da['KlantID']}' class='btn btn-danger'>Verwijderen</a></td>";
                    ?>
                </tr>
            <?php  } ?>
            </tbody>
        </table>
    </body>

</html>