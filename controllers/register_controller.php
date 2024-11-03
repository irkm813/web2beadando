<?php
// controllers/register_controller.php

$title = "Regisztráció";

require_once __DIR__ . '/../models/DatabaseModel.php';

$db = new DatabaseModel();

// Ha a kérés POST, akkor megpróbáljuk regisztrálni a felhasználót
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Jelszavak ellenőrzése
    if ($password !== $confirm_password) {
        $_SESSION['error'] = "A megadott jelszavak nem egyeznek!";
    } elseif ($db->userExists($username, $email)) {
        $_SESSION['error'] = "Ez a felhasználónév vagy e-mail cím már foglalt!";
    } else {
        // Felhasználó regisztrációja
        if ($db->registerUser($username, $email, $password)) {
            // Sikeres regisztráció esetén átirányítás a bejelentkezési oldalra
            $_SESSION['success'] = "Sikeres regisztráció! Most már bejelentkezhetsz.";
            header("Location: /login");
            exit;
        } else {
            $_SESSION['error'] = "Hiba történt a regisztráció során!";
        }
    }
}

// Betöltjük a nézetet
require __DIR__ . '/../views/register.php';
