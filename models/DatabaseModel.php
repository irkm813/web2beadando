<?php

class DatabaseModel {
    private $config;
    private $pdo;

    // Konstruktorban hozzuk létre az adatbázis kapcsolatot
    public function __construct() {
        try {
            $config = require __DIR__ . '/../config.php';
            $dsn = "mysql:host={$config['db_host']};dbname={$config['db_name']}";
            $this->pdo = new PDO($dsn, $config['db_user'], $config['db_pass']);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);   
        } catch (PDOException $e) {
            die('Hiba az adatbázis kapcsolódás közben: ' . $e->getMessage());
        }
    }

    // Dinamikus SELECT lekérdezés
    public function select($table, $columns = "*", $where = "", $join = "", $params = []) {
        $sql = "SELECT $columns FROM $table";

        if ($join) {
            $sql .= " $join";
        }
        
        if ($where) {
            $sql .= " WHERE $where";
        }

        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Dinamikus beszúrás
    public function insert($table, $data) {
        $columns = implode(", ", array_keys($data));
        $placeholders = implode(", ", array_fill(0, count($data), "?"));

        $sql = "INSERT INTO $table ($columns) VALUES ($placeholders)";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(array_values($data));
    }

    // Dinamikus frissítés
    public function update($table, $data, $where, $params = []) {
        $set = "";
        foreach ($data as $column => $value) {
            $set .= "$column = ?, ";
        }
        $set = rtrim($set, ", ");

        $sql = "UPDATE $table SET $set WHERE $where";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute(array_merge(array_values($data), $params));
    }

    // Dinamikus törlés
    public function delete($table, $where, $params = []) {
        $sql = "DELETE FROM $table WHERE $where";
        $stmt = $this->pdo->prepare($sql);

        return $stmt->execute($params);
    }

    // Autentikációs metódus a bejelentkezéshez
    public function dbAuth($username, $password) {
        $result = $this->select('users', 'password', "username = ?", '', [$username]);

        if (!empty($result)) {
            $db_pass = $result[0]["password"];
            return password_verify($password, $db_pass);
        }

        return false;
    }

    // Ellenőrzi, hogy létezik-e a felhasználó a megadott névvel vagy e-mail címmel
    public function userExists($username, $email) {
        $result = $this->select('users', '*', "username = ? OR email = ?", '', [$username, $email]);
        return !empty($result);
    }

    // Új felhasználó regisztrációja
    public function registerUser($username, $email, $password) {
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        return $this->insert('users', [
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'role' => 'user'
        ]);
    }
}
