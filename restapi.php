<?php
// restapi.php
require_once __DIR__ . '/models/DatabaseModel.php';

$db = new DatabaseModel();
$request_method = $_SERVER['REQUEST_METHOD'];

//Autentikáció
if (isset($_GET['username']) && isset ($_GET['password'])){
    $username=$_GET['username'];
    $password=$_GET['password'];
    $db_role =  $db->select('users', 'role', "username=?",'',[$username]);
    $role =  $db_role[0]["role"];
}else{
    $username=null;
    $password=null;
}

// Az URL paraméterek kezelése
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
} else {
    $id = null;
}

// Funkció kiválasztása a HTTP metódus alapján
switch ($request_method) {
    case 'GET':
        if ($id) {
            getNyeremeny($username,$password,$id);
        } else {
            getAllNyeremeny($username,$password);
        }
        break;
    case 'POST':
        createNyeremenyItem($username,$password,$role);
        break;
    case 'PUT':
        updateNyeremenyItem($username,$password,$id,$role);
        break;
    case 'DELETE':
        deleteNyeremenyItem($username,$password,$id,$role);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

// Hírek listázása (GET)
function getAllNyeremeny($username,$password) {
    
    try {
        if (!restApiAuth($username, $password)) {
            throw new Exception('Hibás felhasználónév vagy jelszó');
        }
    
        // Ha a hitelesítés sikeres, lekérdezzük a nyereményeket
        global $db;
        $nyeremenyItems = $db->select('nyeremeny');
        header('Content-Type: application/json');
        echo json_encode($nyeremenyItems);
        
    } catch (Exception $e) {
        // Hibás hitelesítés vagy egyéb hiba esetén
        header('Content-Type: application/json');
        echo json_encode(['message' => $e->getMessage()]);
    }
}

// Egy hír lekérdezése id alapján (GET)
function getNyeremeny($username,$password,$id,$role) {

    try {
        if (!restApiAuth($username, $password)) {
            throw new Exception('Hibás felhasználónév vagy jelszó');
        }

        if ($role != 'admin') {
            throw new Exception('Csak admin jogosultsággal lehetséges');
        }
    
        // Ha a hitelesítés sikeres, lekérdezzük a nyereményt
        global $db;
        $nyeremenyItem = $db->select('nyeremeny', '*', 'id = ?', '', [$id]);
        if ($nyeremenyItem) {
            header('Content-Type: application/json');
            echo json_encode($nyeremenyItem);
        } else {
            header("HTTP/1.0 404 Not Found");
            echo json_encode(['message' => 'Ez a bejegyzés nem található']);
        }
        
    } catch (Exception $e) {
        // Hibás hitelesítés vagy egyéb hiba esetén
        header('Content-Type: application/json');
        echo json_encode(['message' => $e->getMessage()]);
    }
}

// Új bejegyzés létrehozása (POST)
function createNyeremenyItem($username,$password,$role) {

    try {
        if (!restApiAuth($username, $password)) {
            throw new Exception('Hibás felhasználónév vagy jelszó');
        }

        if ($role != 'admin') {
            throw new Exception('Csak admin jogosultsággal lehetséges');
        }
    
        // Ha a hitelesítés sikeres
        global $db;
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['huzasid']) && isset($data['talalat']) && isset($data['darab']) && isset($data['ertek'])) {
            $result = $db->insert('nyeremeny', ['huzasid' => $data['huzasid'], 'talalat' => $data['talalat'],'darab' => $data['darab'], 'ertek' => $data['ertek'] ]);
            if ($result) {
                header("HTTP/1.0 201 Created");
                echo json_encode(['message' => 'bejegyzés létrehozva']);
            } else {
                header("HTTP/1.0 500 Internal Server Error");
                echo json_encode(['message' => 'Hiba történt az elem létrehozásakor']);
            }
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo json_encode(['message' => 'Hiányzó adatok']);
            echo json_encode(['huzasid' => isset($data['huzasid'])]);
            echo json_encode(['talalat' => isset($data['talalat'])]);
            echo json_encode(['darab' => isset($data['darab'])]);
        }
        
        
    } catch (Exception $e) {
        // Hibás hitelesítés vagy egyéb hiba esetén
        header('Content-Type: application/json');
        echo json_encode(['message' => $e->getMessage()]);
    }
}

// bejegyzés frissítése (PUT)
function updateNyeremenyItem($username,$password,$id,$role) {

    try {
        if (!restApiAuth($username, $password)) {
            throw new Exception('Hibás felhasználónév vagy jelszó');
        }

        if ($role != 'admin') {
            throw new Exception('Csak admin jogosultsággal lehetséges');
        }
    
        // Ha a hitelesítés sikeres
        global $db;
        $data = json_decode(file_get_contents("php://input"), true);
        if (isset($data['huzasid']) && isset($data['talalat']) && isset($data['darab']) && isset($data['ertek']) && $id) {
            $result = $db->update('nyeremeny', ['huzasid' => $data['huzasid'], 'talalat' => $data['talalat'],'darab' => $data['darab'], 'ertek' => $data['ertek']] ,'id = ?', [$id]);
            if ($result) {
                header("HTTP/1.0 200 OK");
                echo json_encode(['message' => 'bejegyzés frissítve']);
            } else {
                header("HTTP/1.0 500 Internal Server Error");
                echo json_encode(['message' => 'Hiba történt a frissítés során']);
            }
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo json_encode(['message' => 'Hiányzó adatok']);
        }
        
        
    } catch (Exception $e) {
        // Hibás hitelesítés vagy egyéb hiba esetén
        header('Content-Type: application/json');
        echo json_encode(['message' => $e->getMessage()]);
    }
}

// bejegyzés törlése (DELETE)
function deleteNyeremenyItem($username,$password,$id, $role) {
    try {
        if (!restApiAuth($username, $password)) {
            throw new Exception('Hibás felhasználónév vagy jelszó');
        }

        if ($role != 'admin') {
            throw new Exception('Csak admin jogosultsággal lehetséges');
        }
    
        // Ha a hitelesítés sikeres
        global $db;
        if ($id) {
            $result = $db->delete('nyeremeny', 'id = ?', [$id]);
            if ($result) {
                header("HTTP/1.0 200 OK");
                echo json_encode(['message' => 'Hír törölve']);
            } else {
                header("HTTP/1.0 500 Internal Server Error");
                echo json_encode(['message' => 'Hiba történt a törlés során']);
            }
        } else {
            header("HTTP/1.0 400 Bad Request");
            echo json_encode(['message' => 'Hiányzó ID']);
        }
        
    } catch (Exception $e) {
        // Hibás hitelesítés vagy egyéb hiba esetén
        header('Content-Type: application/json');
        echo json_encode(['message' => $e->getMessage()]);
    }
}

//Autentikáció api hívásokoz félkész
function restApiAuth($username,$password) {
    global $db;
    $db_pass =  $db->select('users', 'password', "username=?",'',[$username]);
    $db_pass =  $db_pass[0]["password"];

    if (password_verify($password, $db_pass)) {
        return true;
    } else {
        return false;
    }

}