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
    <title>view_all_verhuringen</title>
    <link rel="stylesheet" href="./css/View.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>

<body>
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
        <table class="table">
            <thead>
                <tr>
                    <th>VerhuurID</th>
                    <th>StartVerhuurdatum</th>
                    <th>EindeVerhuurdatum</th>
                    <th>KlantID</th>
                    <th>AutoID</th>
                    <th>Kosten</th>
                    <th colspan="3">Action</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <?php
                    $data = $conn->getverhuring();
                    foreach ($data as $da) {
                        echo "<td>" . $da['VerhuurID'] . "</td>";
                        echo "<td>" . $da['StartVerhuurdatum'] . "</td>";
                        echo "<td>" . $da['EindVerhuurdatum'] . "</td>";
                        echo "<td><a class='link' href='view_all_klanten.php?id={$da['KlantID']}'> {$da['KlantID']}--Klant_name: {$da['Klant_naam']}</a></td>";
                        echo "<td><a class='link' href='view_all_cars.php?id={$da['AutoID']}'>" . $da['AutoID'] . "</a></td>";
                        echo "<td>"  . $da['Kosten'] . "</td>";
                        echo "<td><a href='update_verhuring.php?id={$da['VerhuurID']}' class='btn btn-info'>Bewerken</a></td>";
                        echo "<td><a href='add_verhuring.php'class='btn btn-success'>Toevoegen</a></td>";
                        echo "<td><a href='delete_verhuring.php?id={$da['VerhuurID']}' class='btn btn-danger'>Verwijderen</a></td>";
                    ?>
                </tr>
            <?php  } ?>
            </tbody>
        </table>
    </body>

</html>