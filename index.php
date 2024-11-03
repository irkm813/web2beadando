<?php
// index.php - Front Controller
session_start();

error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/models/DatabaseModel.php';

// Adatbázis objektum létrehozása
$db = new DatabaseModel();

// Menü adatok lekérése az adatbázisból
$menuItems = $db->select(
    'menu_items', 
    'menu_items.menu_name, pages.content', 
    '', 
    'JOIN pages ON menu_items.page_id = pages.id'
);

// Ellenőrizzük, hogy a felhasználó be van-e jelentkezve
$isLoggedIn = isset($_SESSION['username']);
$username = $isLoggedIn ? $_SESSION['username'] : null;

// A "Bejelentkezés" menüpontot kihagyjuk, ha a felhasználó be van jelentkezve
$menuItems = array_filter($menuItems, function ($menuItem) use ($isLoggedIn) {
    return !($menuItem['menu_name'] === 'Bejelentkezés' && $isLoggedIn);
});

// Ha a felhasználó be van jelentkezve, hozzáadjuk a profil nevét a menü végéhez
if ($isLoggedIn) {
    $menuItems[] = ['menu_name' => $username, 'content' => '/profile'];
}

// 1. URL értelmezése
$request = $_SERVER['REQUEST_URI'];
$isApi = false;

// A REST API elérésének megfelelő kezelése
if (strpos($request, '/restapi') === 0) {
    require __DIR__ . '/restapi.php';
    exit;
}

// SOAP API elérésének megfelelő kezelése
if (strpos($request, '/soapapi') === 0) {
    require __DIR__ . '/models/SoapServerModel.php';
    exit;
}

// 2. Szétválasztás a route-okra, amennyiben nem az API-t próbáljuk elérni
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
    case '/api-kliens':
        require __DIR__ . '/controllers/api_kliens_controller.php';
        break;
    case '/mnb-currency':
        require __DIR__ . '/controllers/mnb_currency_controller.php';
        break;
    case '/pdf-maker':
        require __DIR__ . '/controllers/pdf_controller.php';
        break;
    case '/login':
        require __DIR__ . '/controllers/login_controller.php';
        break;
    case '/register':
        require __DIR__ . '/controllers/register_controller.php';
        break;
    case '/profile':
        require __DIR__ . '/controllers/profile_controller.php';
        break;
    case '/logout':
        require __DIR__ . '/controllers/logout_controller.php';
        break;
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;
}
