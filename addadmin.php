<?php
include('db_admin.php');
$conn = new Database();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    try {
        $conn->addadmin($_POST['name'], $_POST['email'], $_POST['pass']);
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
    <title>register</title>
    <link rel="stylesheet" href="./css/register.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.2/font/bootstrap-icons.min.css">
</head>

<body>
    <img src="https://mir-s3-cdn-cf.behance.net/project_modules/max_1200/46f37945885079.584030cfd603d.gif" alt="background" class="background-img">
    <nav>
        <a href="home.php"><img src="./img/logoCar.png" alt="car"></a>
        <a href="adminpanel.php">Medewerker Portaal</a>
        <a href="view_all_medewerkers.php">Medewerkers bekijken</a>
        <button id="logoutBtn" class="btn btn-danger" style="width: 100px; background-color:red;">Uitloggen</button>
    </nav>
    <main>
        <form method="POST" class="register">
            <h2>Medewerker toevoegen</h2>
            <input type="text" name="name" placeholder="Name" required><br />
            <input type="email" name="email" id="email" placeholder="Email" required> <br>
            <input type="password" name="pass" placeholder="Wachtwoord" required> <br>
            <button type="submit">Toevoegen</button>
        </form>
    </main>
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