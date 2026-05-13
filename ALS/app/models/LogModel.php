<?php
class LogModel {
    private $conn;
    private $table = 'log_sistem';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllLog() {
        $query = 'SELECT l.*, a.username
                  FROM ' . $this->table . ' l
                  LEFT JOIN admins a ON l.admin_id = a.id
                  ORDER BY l.created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAktivitasTerbaru($limit = 5) {
        $query = 'SELECT l.*, a.username
                  FROM ' . $this->table . ' l
                  LEFT JOIN admins a ON l.admin_id = a.id
                  ORDER BY l.created_at DESC
                  LIMIT :limit';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countErrorHariIni() {
        $query = "SELECT COUNT(*) AS total
                  FROM " . $this->table . "
                  WHERE level = 'error' AND DATE(created_at) = CURDATE()";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function createLog($admin_id, $aktivitas, $level = 'info') {
        $query = 'INSERT INTO ' . $this->table . '
                  (admin_id, aktivitas, level)
                  VALUES (:admin_id, :aktivitas, :level)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':admin_id',  $admin_id);
        $stmt->bindParam(':aktivitas', $aktivitas);
        $stmt->bindParam(':level',     $level);
        return $stmt->execute();
    }

    public function deleteAllLog() {
        $query = 'DELETE FROM ' . $this->table;
        $stmt  = $this->conn->prepare($query);
        return $stmt->execute();
    }
}
