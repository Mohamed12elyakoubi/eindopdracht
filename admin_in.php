<?php
include "db_admin.php";
$conn = new Database();
$error_message = "";

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        if (!isset($_POST['email']) || !isset($_POST['pass'])) {
            throw new Exception("Email and password are required.");
        }

        $email = $_POST['email'];
        $password = $_POST['pass'];

        $error_message = $conn->loginadmin($email, $password);
        if (empty($error_message)) {
            header("location:adminpanel.php");
            exit();
        }
    } catch (Exception $e) {
        $error_message = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inlogen</title>
    <link rel="stylesheet" href="./css/login.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">

</head>

<body>
    <nav>
        <a href="home.php"><img src="img/logoCar.png" alt="car"></a>
        <a href="home.php">Home</a>
        <a href="register.php">Register</a>
        <a href="inlogpagina.php">login</a>
        <a href="auto.php"><i class="bi bi-car-front"></i></a>
    </nav>
    <section> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span> <span></span>
        <div class="signin">
            <div class="content">
                <h2>Sign In</h2>
                    <h3 id="welcome-message" style="color: rgba(52, 152, 219, 0.8);">Welcome Collega</h3>

                <?php if (!empty($error_message)) : ?>
                    <div id="error-message" class="error-message" style="text-align: center; font-size: 30px; color: red;">
                        <?= htmlspecialchars($error_message) ?>
                    </div>
                <?php endif; ?>
                <div class="form">
                    <form action="" method="post">
                        <div class="inputBox">
                            <input type="email" name="email" required> <i>Email</i>
                        </div> <br>
                        <div class="inputBox">
                            <input type="password" name="pass" required> <i>Password</i>
                        </div>
                        <br>
                        <div class="links"><a href="inlogpagina.php">Bent u een klanten?</a>
                        </div>
                        <br>
                        <p style="color: red;"><strong>U logt in als een medewerkers</strong></p>

                        <div class="inputBox">
                            <button type="submit">Log In</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </section>
    <script>
    setTimeout(function () {
        var welcomeMessage = document.getElementById('welcome-message');
        if (welcomeMessage) {
            welcomeMessage.remove();
        }
    }, 3000);
    <?php if (!empty($error_message)) : ?>
        setTimeout(function () {
            var errorMessage = document.getElementById('error-message');
            if (errorMessage) {
                errorMessage.remove();
            }
        }, 5000);
    <?php endif; ?>
</script>
</body>

</html>