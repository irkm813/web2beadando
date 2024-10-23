<?php
// index.php - Front Controller
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 1. URL értelmezése
$request = $_SERVER['REQUEST_URI'];

// 2. Szétválasztás a route-okra
switch ($request) {
    case '/':
        require __DIR__ . '/controllers/home_controller.php';
        break;
    case '/about':
        require __DIR__ . '/controllers/about.php';
        break;
    case '/contact':
        require __DIR__ . '/controllers/contact.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}