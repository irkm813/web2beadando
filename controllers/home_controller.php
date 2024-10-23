<?php
// /../controllers/home_controller.php

require_once __DIR__ . '/../models/DatabaseModel.php';


// Adatbázis objektum létrehozása
$db = new DatabaseModel();

// Menü adatok lekérése
$menuItems = $db->select('menu_items');


$title = "Kezdőlap";

require __DIR__ . '/../views/home.php';