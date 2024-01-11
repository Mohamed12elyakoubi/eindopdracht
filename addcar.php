<?php
include('db.php');
$conn = new Database();
session_start();

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


        $conn->addCar($_POST['name'], $_POST['merk'], $_POST['model'], $_POST['type'], $_POST['jaar'], $_POST['kenteken'], $_POST['kmafstand'], $_POST['color'], $_POST['transmissie'], $_POST['brandstof'], $_POST['prijs'], $targetFilePath);
    } catch (Exception $e) {
        echo $e->getMessage();
    }

}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Auto's</title>
    <link rel="stylesheet" href="./css/add.css">
</head>

<body>
    <div class="terug">
        <button type="button" id="back" class="btn btn-success"><a href="adminpanel.php"> Terug naar Medewerkers Portaal</a></button>
    </div>
    <form method="POST" enctype="multipart/form-data">
        <label for="name">Naam: </label><br />
        <input type="text" id="name" name="name" required><br />
        <label for="Merk">Merk: </label><br />
        <select name="merk" id="Merk" required>
            <option value="Audi">Audi</option>
            <option value="VW">VW</option>
            <option value="BMW">BMW</option>
            <option value="Mercedes">Mercedes Benz</option>
            <option value="Toyota">Toyota</option>
            <option value="Seat">Seat</option>
        </select><br />
        <label for="model">Model:</label><br />
        <input type="text" id="model" name="model" required><br />
        <label for="type">Type: </label><br />
        <select name="type" id="type" required>
            <option value="sedan">Sedan</option>
            <option value="suv">SUV</option>
            <option value="Hatchback">Hatchback</option>
            <option value="coupe">Coupe</option>
        </select><br />
        <label for="jaar">Jaar: </label><br />
        <input type="date" id="year" name="jaar" required><br />

        <label for="kenteken">Kenteken:</label> <br>
               <div class="kenteken2">
                <div class="inset2">
                    <div class="blue2"></div>
                    <input type="text" name="kenteken" />
                </div>
            </div>

        <label for="kmafstand">Km-afstand: </label><br />
        <input type="number" min="0" step=".01" id="kmafstand" name="kmafstand" required><br />
        <label for="color">Color: </label><br />
        <input type="text" id="color" name="color" required><br />

        <label for="Transmissie">Transmissie: </label><br />
        <select name="transmissie" id="transmissie" required> <br>
            <option value="Handschakel">Handschakel</option>
            <option value="Automaat">Automaat</option>
        </select><br>

        <label for="Brandstof">Brandstof: </label><br />
        <select name="brandstof" id="brandstof" required> <br>
            <option value="Benzine">Benzine</option>
            <option value="Diesel">Diesel</option>
            <option value="Elektrisch">Elektrisch</option>
        </select> <br>

        <label for="prijs">Price: </label><br />
        <input type="number" min="0" step=".01" id="price" name="prijs" required><br />

        <label for="image">Auto foto</label> <br>
        <input type="file" name="file">
        <button type="submit" name="upload">Tovoegen</button>
    </form>

</body>

</html>