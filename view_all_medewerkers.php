<?php
session_start();
include('db_admin.php');
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
    <title>view_all_medewerkers</title>
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
                <li> <a class="menu_item" href="view_all_verhuringen.php">Verhuringen bekijken</a></li>
            </ul>

    </header>
    <table class="table">
        <thead>
            <tr>
                <th>Medewerker_ID</th>
                <th>Naam</th>
                <th>email</th>
                <th colspan="3">Action</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <?php
                $data = $conn->getadmin();
                foreach ($data as $da) {
                    echo "<td>" . $da['ID'] . "</td>";
                    echo "<td>" . $da['name'] . "</td>";
                    echo "<td>" . $da['email'] . "</td>";
                    echo "<td><a href='update_medewerker.php?id={$da['ID']}' class='btn btn-info'>Bewerken</a></td>";
                    echo "<td><a href='addadmin.php' class='btn btn-success'>Toevoegen</a></td>";
                    echo "<td><a href='delete_medewerker.php?id={$da['ID']}' class='btn btn-danger'>Verwijderen</a></td>";

                ?>
            </tr>
        <?php  } ?>
        </tbody>
    </table>



</body>

</html>