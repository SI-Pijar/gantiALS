<?php
class PenumpangModel {
    private $conn;
    private $table = 'penumpang';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllPenumpang() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countPenumpang() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM {$this->table}");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getPenumpangById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPenumpangByEmailOrName($credential) {
        $stmt = $this->conn->prepare(
            "SELECT * FROM {$this->table} WHERE email = :credential OR nama_lengkap = :credential LIMIT 1"
        );
        $stmt->execute([':credential' => $credential]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailExists($email) {
        $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE email = :email LIMIT 1");
        $stmt->execute([':email' => $email]);
        return $stmt->fetch() !== false;
    }

    public function createPenumpang($name, $email, $password) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (nama_lengkap, email, password, status, created_at)
             VALUES (:name, :email, :password, 'aktif', NOW())"
        );
        return $stmt->execute([
            ':name' => $name,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
        ]);
    }

    public function updateProfil($id, $nama_lengkap) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET nama_lengkap = :nama WHERE id = :id");
        return $stmt->execute([':nama' => $nama_lengkap, ':id' => $id]);
    }

    public function getPasswordById($id) {
        $stmt = $this->conn->prepare("SELECT password FROM {$this->table} WHERE id = :id LIMIT 1");
        $stmt->execute([':id' => $id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['password'] : null;
    }

    public function updatePassword($id, $password_baru) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET password = :password WHERE id = :id");
        return $stmt->execute([
            ':password' => password_hash($password_baru, PASSWORD_BCRYPT, ['cost' => 12]),
            ':id' => $id,
        ]);
    }

    public function updateStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET status = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }
}