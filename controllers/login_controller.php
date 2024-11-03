<?php
// controllers/login_controller.php
$title = "Bejelentkezés";

require_once __DIR__ . '/../models/DatabaseModel.php';

$db = new DatabaseModel();

// Ha a kérés POST, akkor megpróbáljuk hitelesíteni a felhasználót
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Ha a felhasználó hitelesítése sikeres
    if ($db->dbAuth($username, $password)) {
        // Lekérdezzük a pontos adatokat az adatbázisból
        $userData = $db->select('users', '*', 'username = ?', '', [$username]);

        // Ellenőrizzük, hogy van-e találat, és elmentjük az adatbázisból a pontos `username` értéket
        if (!empty($userData)) {
            $_SESSION['user_id'] = $userData[0]['id'];
            $_SESSION['username'] = $userData[0]['username']; // Az adatbázisból lekért pontos `username`
            
            // Átirányítás a védett oldalra vagy a kezdőlapra
            header("Location: /");
            exit;
        }
    } else {
        // Hibaüzenet beállítása a session-ben
        $_SESSION['error'] = "Helytelen felhasználónév vagy jelszó!";
    }
}

// Betöltjük a nézetet
require __DIR__ . '/../views/login.php';
