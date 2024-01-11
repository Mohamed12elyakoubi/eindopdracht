<?php
session_start();
include('db.php');
$conn = new Database();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: inlogpagina.php");
    exit();
}
if (isset($_GET['id'])) {
    $autoID = $_GET['id'];
    $cardata = $conn->getcar($autoID);
    if ($cardata) {
        $autoName = $cardata['Name'];
        $autoPrijs = $conn->getPricePerDay($autoID);
    }
}
$klantID = $_SESSION['klantID'];
$verhuring = $conn->gereserveerdeauto($klantID);
if ($verhuring) {
    $autoName = $verhuring['Name'];
}
$data = $conn->verhuring($klantID);
if ($data) {
    $startVerhuurdatum = $data['StartVerhuurdatum'];
    $eindVerhuurdatum = $data['EindVerhuurdatum'];
    $kosten = $data['Kosten'];
}

$userData = $conn->getUser($klantID);
if ($userData) {
    $id = $userData['KlantID'];
    $klantNaam = $userData['Klant_naam'] . ' ' . $userData['klant_achternaam'];
    $adres = $userData['Adres'];
    $telefoon = $userData['Telefoonnummer'];
} else {
    $klantNaam = "Gebruiker";
}

$currentDate = date('d/m/Y');
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Factuur</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css" integrity="sha512-MV7K8+y+gLIBoVD59lQIYicR65iaqukzvf/nwasF0nqhPay5w/9lJmVM2hMDcnK1OnMGCdVK+iQrJ7lzPJQd1w==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/factuur.css">
    <script src="https://raw.githack.com/eKoopmans/html2pdf/master/dist/html2pdf.bundle.js"></script>
</head>

<body>

    <div class="Factuur" id="print-area">
        <div class="Factuur">
            <div class="Factuur-container">
                <div class="Factuur-head">
                    <div class="Factuur-head-top">
                        <div class="img">
                            <img src="./img/logoCar.png">
                            <h4>Car 4 You</h4>
                            <p>Carnapstraat 118 Amsterdam</p>
                            <p>0052126122</p>
                            <p>info@car4you.nl</p>

                        </div>
                        <div class="Factuur-head-top-right text-end">
                            <h3>Factuur</h3>
                        </div>
                    </div>
                    <div class="hr"></div>
                    <div class="Factuur-head-middle">
                        <div class="invoice-head-middle-left text-start">
                            <p><span class="text-bold">Datum</span>: <?php echo $currentDate; ?> <br>
                            <h4>Factuur voor : </h4>
                            <p><?php echo $klantNaam; ?></p>
                            <p><?php echo $adres; ?></p>
                            <p>0<?php echo $telefoon; ?></p>

                            </p>
                        </div>
                        <div class="Factuur-head-middle-right text-end">
                            <p>
                                <spanf class="text-bold">Factuur No:</span><?php echo $id; ?>
                            </p>
                        </div>
                    </div>

                    <div class="hr"></div>
                    <div class="Factuur-head-bottom">
                        <div class="invoice-details">
                            <h2>Factuur Details</h2>
                            <table>
                                <tr>
                                    <td><span class="text-bold">Klant:</span></td>
                                    <td><?php echo $klantNaam; ?></td>
                                </tr>
                                <tr>
                                    <td><span class="text-bold">Auto:</span></td>
                                    <td><?php echo isset($autoName) ? $autoName : ""; ?></td>
                                </tr>
                                <tr>
                                    <td><span class="text-bold">Start datum:</span></td>
                                    <td><?php echo $startVerhuurdatum ?></td>
                                </tr>
                                <tr>
                                    <td><span class="text-bold">Eind datum:</span></td>
                                    <td><?php echo  $eindVerhuurdatum ?></td>
                                </tr>
                                <tr>
                                    <td><span class="text-bold">Cost:</span></td>
                                    <td>€<?php echo isset($kosten) ? $kosten : ""; ?></td>
                                </tr>
                            </table>
                        </div>
                        <br>

                    </div>
                </div>
            </div>
            <div class="Factuur-foot text-center">
                <p><span class="text-bold text-center">NOTE:&nbsp;</span>Dit is een door de computer gegenereerd ontvangstbewijs en vereist geen fysieke handtekening.</p> <br>

                <div class="Factuur-btns">
                    <button type="button" class="Factuur-btn" onclick="printFactuur()">
                        <span>
                            <i class="fa-solid fa-print"></i>
                        </span>
                        <span>Print</span>
                    </button>
                    <button type="button" class="Factuur-btn" id="downloadBtn">
            <span>
                <i class="fa-solid fa-download"></i>
            </span>
            <span>Download</span>
        </button>
    </div>
            </div>

        </div>
        <a href="klant_panel.php"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-arrow-bar-left" id="backtohome" style="margin-left:320px" color="green" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M12.5 15a.5.5 0 0 1-.5-.5v-13a.5.5 0 0 1 1 0v13a.5.5 0 0 1-.5.5M10 8a.5.5 0 0 1-.5.5H3.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L3.707 7.5H9.5a.5.5 0 0 1 .5.5" />
                </svg></a>
        <script>
            function printFactuur() {
                window.print();
            }
            document.getElementById("downloadBtn").addEventListener("click", function () {
            var element = document.getElementById("print-area");

            html2pdf(element, {
                margin: 1,
                filename: 'factuur.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'mm', format: 'a4', orientation: 'portrait' }
            });
        });

            var currentDateElement = document.getElementById("currentDate");
            var currentDate = new Date();
            var day = currentDate.getDate();
            var month = currentDate.getMonth() + 1;
            var year = currentDate.getFullYear();

            var formattedDate = (day < 10 ? '0' : '') + day + '/' + (month < 10 ? '0' : '') + month + '/' + year;
            currentDateElement.textContent = formattedDate;
        </script>
</body>

</html>