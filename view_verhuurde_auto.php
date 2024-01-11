<?php
session_start();
include('db.php');
$conn = new Database();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_out.php");
    exit();
}
$hudigedag = date('Y-m-d');
$reservedCars = $conn->getReservedCarsForDate($hudigedag);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserved Cars Today</title>
    <link rel="stylesheet" href="./css/styles.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

</head>
<header>

            <input type="checkbox" id="hamburger"/>
            <label for="hamburger" class="hamburger_btn">
                <span></span>
            </label>

            <ul class="hamburger_menu">
                <li> <a class="menu_item" href="adminpanel.php">Medewerkers Portaal</a></li>
                <li> <a class="menu_item" href="view_beschikbaar_auto's.php">beschikbare Auto</a></li>
            </ul>

    </header>
<body>
    <h2>Gereserveerde auto's op <?php echo $hudigedag; ?></h2>

    <table>
        <thead>
            <tr>
                <th>VerhuurID</th>
                <th>StartVerhuurdatum</th>
                <th>EindVerhuurdatum</th>
                <th>KlantID</th>
                <th>AutoID</th>
                <th>Kosten</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($reservedCars as $car) : ?>
                <tr>
                    <td><?php echo $car['VerhuurID']; ?></td>
                    <td><?php echo $car['StartVerhuurdatum']; ?></td>
                    <td><?php echo $car['EindVerhuurdatum']; ?></td>
                    <td><?php echo $car['KlantID']; ?></td>
                    <td><?php echo $car['AutoID']; ?></td>
                    <td>€<?php echo $car['Kosten']; ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
