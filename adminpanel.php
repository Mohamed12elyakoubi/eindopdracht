<?php
include('db_admin.php');
$conn = new database();
session_start();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_out.php");
    exit();
}header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

$adminID = $_SESSION['ID'];
$admindata = $conn->getadmin($adminID);
$name = $admindata['name']
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Page</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/admin.css">

</head>

<body>
<header>

            <input type="checkbox" id="hamburger"/>
            <label for="hamburger" class="hamburger_btn">
                <span></span>
            </label>

            <ul class="hamburger_menu">
                <li> <a class="menu_item" href="view_verhuurde_auto.php">Verhuurde Auto's</a></li>
                <li> <a class="menu_item" href="view_beschikbaar_auto's.php">beschikbare Auto</a></li>
            </ul>

    </header>
    <h1>Welcome <strong style="color: green;"><?php echo $name ?> </strong></h1>
    <h3>handleiding</h3> <br>
    <button id="logoutBtn" class="btn btn-danger" style="width: 100px; font-size:larger; margin-left:720px">Logout</button>

    <table class="table">
        <thead>
            <th> <button class="btn btn-info"><a href="view_all_klanten.php">klanten bekijken</a></button> </th>
            <th> <button class="btn btn-info"><a href="view_all_cars.php">Auto bekijken</a></button> </th>
            <th><button class="btn btn-info"><a href="view_all_medewerkers.php">Medewerkers bekijken</a> </button> </th>
            <th> <button class="btn btn-info"><a href="view_all_verhuringen.php">Verhuringen bekijken</a></button> </th>

        </thead>
        <tbody>
            <tr>
                <td>
                    <ul>
                        <li> <strong style="color: rgb(19, 132, 150);">Bewerken:</strong> Je kan een klant informatie bewerken</li>
                        <li> <strong style="color: red;">Verwijderen: </strong>Je kan een klant verwijderen</li>
                        <li> <strong style="color: green;">Toevoegen: </strong>Je kan een klant toevoegen</li>

                    </ul>
                </td>
                <td>
                    <li> <strong style="color: rgb(19, 132, 150);">Bewerken:</strong> Je kan een auto informatie bewerken</li>
                    <li> <strong style="color: red;">Verwijderen: </strong>Je kan een auto verwijderen</li>
                    <li> <strong style="color: green">Toevoegen: </strong>Je kan een auto toevoegen</li>
                </td>
                <td>
                    <li> <strong style="color: rgb(19, 132, 150);">Bewerken:</strong> Je kan een medewerker informatie bewerken</li>
                    <li> <strong style="color: red;">Verwijderen: </strong>Je kan een medewerker verwijderen</li>
                    <li> <strong style="color: green;">Toevoegen: </strong>Je kan een medewerker toevoegen</li>
                </td>
                <td>
                    <li> <strong style="color: rgb(19, 132, 150);">Bewerken:</strong> Je kan een verhuring bewerken</li>
                    <li> <strong style="color: red;">Verwijderen: </strong>Je kan een verhuring verwijderen</li>
                    <li> <strong style="color: green;">Toevoegen: </strong>Je kan een verhuring toevoegen</li></td>
            </tr>
        </tbody>
    </table><br>

    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        $(document).ready(function() {
            $("#logoutBtn").click(function() {
                var form = $('<form action="admin_out.php" method="post"></form>');
                form.appendTo('body').submit();
            });
        });
    </script>

</body>

</html>