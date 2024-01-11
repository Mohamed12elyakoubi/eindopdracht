<?php
session_start();
include('db.php');
$conn = new Database();
$message= '';
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_out.php");
    exit();
}
if (isset($_GET['id'])) {
    $autoID = $_GET['id'];
    $cardata = $conn->getcar($autoID);
    if ($cardata) {
        $Name = $cardata['Name'];
        $merk = $cardata['Merk'];
        $model = $cardata['Model'];
        $type = $cardata['type'];
        $jaar = $cardata['Jaar'];
        $kenteken = $cardata['Kenteken'];
        $kmafstand = $cardata['kmafstand'];
        $color = $cardata['Color'];
        $Transmissie = $cardata['Transmissie'];
        $brandstof = $cardata['Brandstof'];
        $prijs = $cardata['Prijs'];
        $imagename = $cardata['imagename'];
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {

        $targetFilePath = "img/";

        if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
            $allowedTypes = array('jpg', 'jpeg', 'png', 'gif');
            $fileExtension = strtolower(pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION));

            if (in_array($fileExtension, $allowedTypes)) {
                $name = $_FILES['file']['name'];
                $targetFilePath = "img/" . $name;

                if (move_uploaded_file($_FILES["file"]["tmp_name"], $targetFilePath)) {
                } else {
                    echo "Er is een probleem opgetreden bij het verplaatsen van het bestand.";
                }
            } else {
                echo "Alleen JPG, JPEG, PNG en GIF-bestanden zijn toegestaan.";
            }
        } else {
            echo "Er is een probleem opgetreden bij het uploaden van het bestand.";
        }
        $conn->editcar($_POST['Name'], $_POST['Merk'], $_POST['Model'], $_POST['type'], $_POST['Jaar'], $_POST['Kenteken'], $_POST['kmafstand'], $_POST['Color'], $_POST['Transmissie'], $_POST['Brandstof'], $_POST['Prijs'], $targetFilePath, $_GET['id']);
        echo '<div class="message" style="text-align: center; font-size:30px; color: green;"  onclick="redirectToIndex();">' . "Auto is succesvol geupdate" . '</div>';
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Klant</title>
    <link rel="stylesheet" href="./css/update.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>

<body>
    <script>
        function redirectToIndex() {
            window.location.href = 'view_all_cars.php';
        }
    </script>
    
    <div class="container">
        <div class="message" style="text-align: center; font-size: 20px; color: #1e88e5; margin-bottom: 20px;" onclick="redirectToIndex();">
            <?php echo $message; ?>
        </div>

        <form method="POST" enctype="multipart/form-data" class="cars">
            <label for="name">Naam: </label><br />
            <input type="text" id="name" name="Name" value="<?php echo $Name; ?>" required><br />
            <label for="Merk">Merk: </label><br />
            <select name="Merk" id="Merk" required>
                <option value="Audi" <?php if ($merk == 'Audi') echo 'selected'; ?>>Audi</option>
                <option value="VW" <?php if ($merk == 'VW') echo 'selected'; ?>>VW</option>
                <option value="BMW" <?php if ($merk == 'BMW') echo 'selected'; ?>>BMW</option>
                <option value="Mercedes" <?php if ($merk == 'Mercedes') echo 'selected'; ?>>Mercedes Benz</option>
                <option value="Toyota" <?php if ($merk == 'Toyota') echo 'selected'; ?>>Toyota</option>
                <option value="Seat" <?php if ($merk == 'Seat') echo 'selected'; ?>>Seat</option>
            </select><br />

            <label for="model">Model:</label><br />
            <input type="text" id="model" name="Model" value="<?php echo $model; ?>" required><br />
            <label for="type">Type: </label><br />
            <select name="type" id="type" required>
                <option value="sedan" <?php if ($type == 'sedan') echo 'selected'; ?>>Sedan</option>
                <option value="suv" <?php if ($type == 'suv') echo 'selected'; ?>>SUV</option>
                <option value="Hatchback" <?php if ($type == 'Hatchback') echo 'selected'; ?>>Hatchback</option>
                <option value="coupe" <?php if ($type == 'coupe') echo 'selected'; ?>>Coupe</option>
            </select><br/>

            <label for="jaar">Jaar: </label><br />
            <input type="date" id="year" name="Jaar" value="<?php echo $jaar; ?>" required><br />

            <label for="kenteken">Kenteken:</label> <br>
            <input type="text" id="kenteken" name="Kenteken" value="<?php echo $kenteken; ?>" required> <br>

            <label for="kmafstand">Km-afstand: </label><br />
            <input type="number" min="0" step=".01" id="kmafstand" name="kmafstand" value="<?php echo $kmafstand; ?>" required><br />
            <label for="color">Color: </label><br />
            <input type="text" id="color" name="Color" value="<?php echo $color; ?>" required><br />

            <label for="Transmissie">Transmissie: </label><br />
            <select name="Transmissie" id="transmissie" required>
                <option value="Handschakel" <?php if ($Transmissie == 'Handschakel') echo 'selected'; ?>>Handschakel</option>
                <option value="Automaat" <?php if ($Transmissie == 'Automaat') echo 'selected'; ?>>Automaat</option>
            </select><br />


            <label for="Brandstof">Brandstof: </label><br />
            <select name="Brandstof" id="brandstof" required>
                <option value="Benzine" <?php if ($brandstof == 'Benzine') echo 'selected'; ?>>Benzine</option>
                <option value="Diesel" <?php if ($brandstof == 'Diesel') echo 'selected'; ?>>Diesel</option>
                <option value="Elektrisch" <?php if ($brandstof == 'Elektrisch') echo 'selected'; ?>>Elektrisch</option>
            </select><br />


            <label for="prijs">Price: </label><br />
            <input type="number" min="0" step=".01" id="price" name="Prijs" value="<?php echo $prijs; ?>" required><br />

            <label for="image">Auto foto</label> <br>
            <input type="file" name="file" value="<?php echo $imagename; ?>" required>
            <button type="submit" name="upload">Tovoegen</button>
        </form>
    </div>
</body>

</html>