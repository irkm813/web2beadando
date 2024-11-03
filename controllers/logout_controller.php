<?php
// controllers/logout_controller.php

session_start();
session_unset(); // Minden session változót törlünk
session_destroy(); // A session-t megszüntetjük

// Visszairányítjuk a felhasználót a bejelentkezési oldalra vagy a kezdőlapra
header("Location: /login");
exit;
