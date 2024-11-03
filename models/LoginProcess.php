<?php
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/DatabaseModel.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $db = new DatabaseModel();

    if ($db->dbAuth($username, $password)) {
        $_SESSION['user_id'] = $username;
        $_SESSION['username'] = $username;
        header("Location: /protected_page.php");
        exit;
    } else {
        $_SESSION['error'] = "Helytelen felhasználónév vagy jelszó!";
        header("Location: /login.php");
        exit;
    }
}
?>
