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
$isApi= false;

//A rest api elérés megfelelő kezelése
if (strpos($request, '/restapi') === 0) {
    require __DIR__ . '/restapi.php';
    exit;
}

//Soap api elérés megfelelő kezelése
if (strpos($request, '/soapapi') === 0) {
    require __DIR__ . '/models/SoapServerModel.php';
    exit;
}

// 2. Szétválasztás a route-okra, amennyiben nem az api-t próbáljuk elérni
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
    default:
        http_response_code(404);
        require __DIR__ . '/views/404.php';
        break;

}

