<?php
// index.php - Front Controller
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/models/DatabaseModel.php';

// Adatbázis objektum létrehozása
$db = new DatabaseModel();

// Menü adatok lekérése
$menuItems = $db->select(
    'menu_items', 
    'menu_items.menu_name, pages.content', 
    '', 
    'JOIN pages ON menu_items.page_id = pages.id'
);

// 1. URL értelmezése
$request = $_SERVER['REQUEST_URI'];

// 2. Szétválasztás a route-okra
switch ($request) {
    case '/':
        require __DIR__ . '/controllers/home_controller.php';
        break;
    case '/left-sidebar':
        require __DIR__ . '/controllers/left_sidebar_controller.php';
        break;
    case '/right-sidebar':
        require __DIR__ . '/controllers/right_sidebar_controller.php';
        break;
    case '/no-sidebar':
        require __DIR__ . '/controllers/no_sidebar_controller.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}

// Menü betöltése
include __DIR__ . '/includes/menu.php';