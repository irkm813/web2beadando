<?php
include __DIR__ . '/../includes/header.php';
require_once __DIR__ . '/DatabaseModel.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "A megadott jelszavak nem egyeznek!";
        header("Location: /register.php");
        exit;
    }

    $db = new DatabaseModel();

    if ($db->userExists($username, $email)) {
        $_SESSION['error'] = "Ez a felhasználónév vagy e-mail cím már foglalt!";
        header("Location: /register.php");
        exit;
    }

    if ($db->registerUser($username, $email, $password)) {
        header("Location: /login.php");
        exit;
    } else {
        $_SESSION['error'] = "Hiba történt a regisztráció során!";
        header("Location: /register.php");
        exit;
    }
}
?>
