<?php
session_start();
include('db.php');
$conn = new Database();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_out.php");
    exit();
}
$message = '';
$kosten = 0; 
$peroide = 0;

if (isset($_GET['id'])) {
    $verhuurID = $_GET['id'];
}

try {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $startVerhuurdatum = $_POST['StartVerhuurdatum'];
        $eindVerhuurdatum = $_POST['EindVerhuurdatum'];
        $autoID = $_POST['AutoID'];

        $prijs = $conn->getPricePerDay($autoID);

        if ($prijs !== null) {
            $startDateTime = new DateTime($startVerhuurdatum);
            $eindDateTime = new DateTime($eindVerhuurdatum);
            $peroide = $startDateTime->diff($eindDateTime)->format('%a');

            $kosten = $prijs * $peroide;

            $result = $conn->editverhuring($startVerhuurdatum, $eindVerhuurdatum, $autoID, $kosten, $verhuurID);

            if ($result === true) {
                $_SESSION['update_success'] = true;
            } else {
                echo "Er is een fout opgetreden bij het bijwerken van de reservering: " . $result;
            }
        } else {
            echo "Fout bij het ophalen van de prijs van de auto.";
        }
    }
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Verhuring bewerken</title>
    <link rel="stylesheet" href="./css/update.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="container">
        <?php
        if (isset($_SESSION['update_success']) && $_SESSION['update_success']) {
            echo "<div class='success-message' style='color:green;'>Reservering succesvol bijgewerkt. <br> Kosten: € {$kosten}, <br> periode: {$peroide} dagen</div>";
            unset($_SESSION['update_success']);
        }
        ?>
        <button type="button" class="btn btn-success"><a href="view_all_verhuringen.php"> Terug naar Verhuringen</a></button>

        <h2>Reservering bewerken</h2>
        <form action="" class="update" method="post">
            <label for="StartVerhuurdatum">StartVerhuurdatum</label>
            <input type="date" name="StartVerhuurdatum" id="startDatum" required> <br>
            <label for="EindVerhuurdatum">EindVerhuurdatum</label>

            <input type="date" name="EindVerhuurdatum" id="eindDatum" required> <br>
            <br>
            <select name="AutoID" required class="form-select form-select-sm">
                <option value="" disabled>Selecteer een auto</option>
                <?php
                $autoResult = $conn->getAllCars();
                if ($autoResult) {
                    foreach ($autoResult as $auto) {
                        $selected = ($auto['AutoID'] == $autoID) ? 'selected' : '';

                        echo "<option value='{$auto['AutoID']}' $selected>
                                <strong>{$auto['Name']} <br>- <strong>Prijs:</strong> € {$auto['Prijs']} per dag
                              </option>";
                    }
                } else {
                    echo "<option value='' disabled>No cars available</option>";
                }
                ?>
            </select>

            <input type="hidden" name="Kosten" id="prijs" value="<?= $kosten; ?>">

            <button type="submit" class="btn btn-warning">Reserveer</button>
        </form>
    </div>
</body>
</html>
