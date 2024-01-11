<?php
include "db.php";
$conn = new Database();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Page</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="./css/home.css">
</head>

<body>

    <nav>
        <a href="home.php"><img src="img/logoCar.png" alt="car"></a>
        <a href="home.php">Home</a>
        <a href="register.php">Register</a>
        <a href="inlogpagina.php">login</a>
        <a href="auto.php"><i class="bi bi-car-front"></i></a>

    </nav>
    <main>
        <h1>Welkom bij Car 4 YOU</h1>
        </video>
        <iframe width="700" height="400" src="https://www.youtube.com/embed/s-m6xj-uRvA?autoplay=1&mute=1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
        <article>
            <p><strong>Wat is Car 4 You?</strong></p>
            <p>Car 4 you is een platform dat je in staat stelt om verhuuren van auto's.</p>
            <p><strong>Waroom Car 4 You?</strong></p>
            <p>Door middel van onze website kan je gemakkelijk en snel zoeken naar de juiste auto voor een beste prijs </p>
            <ul>
                <li>Vind snel en gemakkelijk de juiste auto voor jou. </li>
                <li>Zorg ervoor dat je rentoutje goed afloopt door te
                    reserveren via onze veilige website.</li>
                <li>Blijf op de hoogte van alle nieuwtjes over de auto
                    die je wilt huren. Onze app geeft je dagelijks
                    5 meldingen zodra er iets nieuws is.</li>
            </ul>
            <h3>Auto reserveren?</h3>
            <li>U moet eerste inloggen om auto te reserveren <i class="bi bi-exclamation"></i></li>
            <h2>Bekijk onze collectie</h2>
            <a href="auto.php">Click hier om onze collectie te bekijken </a><br>
        </article>
    </main>
    <br>
    <footer>
        <div class="footer-content">
            <h3>Contactgegevens</h3>
            <p><strong>Openingstijden:</strong></p>
            <p>Ma t/m zo: 7.00 uur - 23.00 uur</p>
            <a href="https://www.google.com/maps/place/Carnapstraat+118,+1062+KT+Amsterdam/@52.3546881,4.8370766,17z/data=!3m1!4b1!4m6!3m5!1s0x47c5e3bde195bcb9:0x38539b6003b5add5!8m2!3d52.3546849!4d4.8396515!16s%2Fg%2F11rtl_lknq?entry=ttu">
                <p> <strong>Adres:</strong> Carnapstraat 118, Amsterdam</p>
            </a>
            <a href="mailto:info@car4you.com">
                <p>Email: Info@car4you.com</p>
            </a>
            <a href="tel:+31687989245">Telefoon: 0052126122</a>

        </div>
        <div class="footer-content">
            <h3>Volg ons</h3>
            <p><i class="bi bi-facebook"></i>Facebook</p>
            <p><i class="bi bi-twitter-x"></i>Twitter</p>
            <p><i class="bi bi-instagram"></i>Instagram</p>
        </div>
    </footer>

</body>

</html>