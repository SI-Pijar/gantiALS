<?php
class PengaturanModel {
    private $conn;
    private $table = 'pengaturan';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllPengaturan() {
        $query = 'SELECT kunci, nilai FROM ' . $this->table;
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        // kembalikan sebagai key => value
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $result = [];
        foreach ($rows as $row) {
            $result[$row['kunci']] = $row['nilai'];
        }
        return $result;
    }

    public function upsert($kunci, $nilai) {
        $query = 'INSERT INTO ' . $this->table . ' (kunci, nilai)
                  VALUES (:kunci, :nilai)
                  ON DUPLICATE KEY UPDATE nilai = :nilai2';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':kunci',  $kunci);
        $stmt->bindParam(':nilai',  $nilai);
        $stmt->bindParam(':nilai2', $nilai);
        return $stmt->execute();
    }
}
