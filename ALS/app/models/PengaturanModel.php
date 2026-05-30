<?php
class PengaturanModel {
    private $conn;
    private $table = 'pengaturan';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getSettings() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} LIMIT 1");
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: [];
    }

    public function updateSettings($email_support, $nomor_telepon, $alamat) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM {$this->table}");
        $stmt->execute();
        $exists = (bool)$stmt->fetchColumn();

        $query = $exists
            ? "UPDATE {$this->table} SET email_support = :email, nomor_telepon = :telp, alamat = :alamat LIMIT 1"
            : "INSERT INTO {$this->table} (email_support, nomor_telepon, alamat) VALUES (:email, :telp, :alamat)";

        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            ':email' => $email_support,
            ':telp' => $nomor_telepon,
            ':alamat' => $alamat,
        ]);
    }
}
