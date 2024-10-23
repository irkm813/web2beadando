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
    public function select($table, $columns = "*", $where = "", $params = []) {
        $sql = "SELECT $columns FROM $table";

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
}