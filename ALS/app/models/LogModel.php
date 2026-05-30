<?php
class LogModel {
    private $conn;
    private $table = 'logs';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllLog() {
        $stmt = $this->conn->prepare(
            "SELECT l.*, a.username
             FROM {$this->table} l
             LEFT JOIN admins a ON l.admin_id = a.id
             ORDER BY l.created_at DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLogByLevel($level) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE level = :level ORDER BY created_at DESC");
        $stmt->execute([':level' => $level]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLogFiltered($level, $tanggal) {
        $query  = "SELECT * FROM {$this->table} WHERE 1=1";
        $params = [];

        if ($level) {
            $query .= ' AND level = :level';
            $params[':level'] = $level;
        }
        if ($tanggal) {
            $query .= ' AND DATE(created_at) = :tanggal';
            $params[':tanggal'] = $tanggal;
        }

        $stmt = $this->conn->prepare("{$query} ORDER BY created_at DESC");
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAktivitasTerbaru($limit = 5) {
        $stmt = $this->conn->prepare(
            "SELECT l.*, a.username
             FROM {$this->table} l
             LEFT JOIN admins a ON l.admin_id = a.id
             ORDER BY l.created_at DESC
             LIMIT :limit"
        );
        $stmt->bindValue(':limit', (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countLogByLevel($level) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM {$this->table} WHERE level = :level");
        $stmt->execute([':level' => $level]);
        return (int)$stmt->fetchColumn();
    }

    public function createLog($admin_id, $aktivitas, $level = 'info') {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (admin_id, pesan, level) VALUES (:admin_id, :pesan, :level)"
        );
        return $stmt->execute([':admin_id' => $admin_id, ':pesan' => $aktivitas, ':level' => $level]);
    }

    public function deleteAllLog() {
        return $this->conn->prepare("DELETE FROM {$this->table}")->execute();
    }
}
