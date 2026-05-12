<?php

class AdminModel {

    private $conn;
    private $table = 'admins';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findByUsername($username) {

        $query = "SELECT * FROM {$this->table} 
                  WHERE username = ? 
                  LIMIT 1";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result = $stmt->get_result();
        
        return $result->fetch_assoc();
    }

    public function countPengguna() {

        $query = "SELECT COUNT(*) as total 
                  FROM {$this->table} 
                  WHERE role = 'pengguna'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $data = $result->fetch_assoc();

        return $data['total'];
    }

    public function catatLog($adminId, $aktivitas, $level = 'info') {

        $query = "INSERT INTO log_sistem 
                  (admin_id, aktivitas, level, created_at) 
                  VALUES (?, ?, ?, NOW())";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('iss', $adminId, $aktivitas, $level);
        $stmt->execute();
    }
}