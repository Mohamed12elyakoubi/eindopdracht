<?php
session_start();
include('db_admin.php');
$conn = new Database();
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_out.php");
    exit();
}
$message = '';

if (isset($_GET['id'])) {
    $adminID = $_GET['id'];
    $adminData = $conn->getadmin($adminID);

    if ($adminData) { 
        $name = $adminData['name'];
        $email = $adminData['email'];
        $wachtwoord = $adminData['Wachtwoord'];
    }
    try{
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $hash = password_hash($_POST['pass'], PASSWORD_DEFAULT);
            $success = $conn->editadmin($_POST['name'], $_POST['email'], $hash, $_GET['id']);
            if ($success) {
                $_SESSION['update_success'] = true;
            } else {
                $message = "Medewerker is bijgewerkt.";
            }
        }
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
    <title>Medewerker bewerken</title>
    <link rel="stylesheet" href="./css/update.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
</head>
<body>

    <div class="container">
        <!-- <div class="message" style="text-align: center; font-size: 20px; color: #1e88e5; margin-bottom: 20px;" onclick="redirectToIndex();">
        </div> -->

        <form method="POST" action="view_all_medewerkers.php" class="update">
            <h2>Medewerker bewerken</h2>
            <input type="text" name="name" value="<?php echo $name; ?>" required><br />
            <input type="email" name="email" id="email" placeholder="Email" value="<?php echo $email; ?>" required> <br>
            <input type="password" name="pass" placeholder="Wachtwoord" value="<?php echo $wachtwoord; ?>" required> <br>
            <button type="submit">Bewerken</button>
        </form>
    </div>
</body>
</html>
