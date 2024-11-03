<?php
// /../controllers/profile_controller.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$title = "Profile";

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
if (!isset($_SESSION['username'])) {
    $_SESSION['error'] = "Nem vagy bejelentkezve.";
    header("Location: /login");
    exit;
}

require_once __DIR__ . '/../models/DatabaseModel.php';
$db = new DatabaseModel();

$username = $_SESSION['username'];
$userData = $db->select("users", "*", "username = ?", "", [$username]);

// Ellenőrizzük, hogy van-e ilyen felhasználó
if (!$userData) {
    // Hibás session elbontása
    session_unset(); // Minden session változót töröl
    session_destroy(); // A sessiont teljesen elbontja

    // Hibaüzenet beállítása
    session_start(); // Új session indítása a hibaüzenethez
    $_SESSION['error'] = "Hibás felhasználói adatok miatt kijelentkeztetve.";

    // Átirányítás a bejelentkezési oldalra
    header("Location: /login");
    exit;
}

// Az első találatot vesszük, mert a `username` egyedi
$userData = $userData[0];

require __DIR__ . '/../views/profile.php';
