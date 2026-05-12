<?php

class UserModel {
    private $conn;
    private $table = 'users';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllUsers() {
        $query = 'SELECT id, name, email, created_at FROM ' . $this->table . ' ORDER BY created_at DESC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }
}
