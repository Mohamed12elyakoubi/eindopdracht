<?php
session_start();

include "db.php";
$db = new Database();
session_start();

if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true) {
    header("location: admin_out.php");
    exit();
}
try {
    if ($_GET['id']) {
        $db->deleteUser($_GET['id']);
        $_SESSION['delete_success'] = true;
        header("Location: view_all_klanten.php");
        exit();
    }
} catch (Exception $e) {
    echo $e->getMessage();
}
?>
