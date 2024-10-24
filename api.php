<?php
// api.php
require_once __DIR__ . '/models/DatabaseModel.php';

$db = new DatabaseModel();
$request_method = $_SERVER['REQUEST_METHOD'];

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
            getNews($id);
        } else {
            getAllNews();
        }
        break;
    case 'POST':
        createNewsItem();
        break;
    case 'PUT':
        updateNewsItem($id);
        break;
    case 'DELETE':
        deleteNewsItem($id);
        break;
    default:
        header("HTTP/1.0 405 Method Not Allowed");
        break;
}

// Hírek listázása (GET)
function getAllNews() {
    global $db;
    $newsItems = $db->select('news');
    header('Content-Type: application/json');
    echo json_encode($newsItems);
}

// Egy hír lekérdezése id alapján (GET)
function getNews($id) {
    global $db;
    $newsItem = $db->select('news', '*', 'id = ?', '', [$id]);
    if ($newsItem) {
        header('Content-Type: application/json');
        echo json_encode($newsItem);
    } else {
        header("HTTP/1.0 404 Not Found");
        echo json_encode(['message' => 'Ez a hír nem található']);
    }
}

// Új hír létrehozása (POST)
function createNewsItem() {
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['title']) && isset($data['author_id']) && isset($data['content']) ) {
        $result = $db->insert('news', ['title' => $data['title'], 'author_id' => $data['author_id'],'content' => $data['content'] ]);
        if ($result) {
            header("HTTP/1.0 201 Created");
            echo json_encode(['message' => 'Hír létrehozva']);
        } else {
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode(['message' => 'Hiba történt az elem létrehozásakor']);
        }
    } else {
        header("HTTP/1.0 400 Bad Request");
        echo json_encode(['message' => 'Hiányzó adatok']);
    }
}

// Hír frissítése (PUT)
function updateNewsItem($id) {
    global $db;
    $data = json_decode(file_get_contents("php://input"), true);
    if (isset($data['title']) && isset($data['author_id']) && isset($data['content']) && $id) {
        $result = $db->update('news', ['title' => $data['title'], 'author_id' => $data['author_id'],'content' => $data['content']],'id = ?', [$id]);
        if ($result) {
            header("HTTP/1.0 200 OK");
            echo json_encode(['message' => 'Hír frissítve']);
        } else {
            header("HTTP/1.0 500 Internal Server Error");
            echo json_encode(['message' => 'Hiba történt a frissítés során']);
        }
    } else {
        header("HTTP/1.0 400 Bad Request");
        echo json_encode(['message' => 'Hiányzó adatok']);
    }
}

// Hír törlése (DELETE)
function deleteNewsItem($id) {
    global $db;
    if ($id) {
        $result = $db->delete('news', 'id = ?', [$id]);
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
}
