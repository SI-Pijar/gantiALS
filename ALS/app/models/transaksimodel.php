<?php

class TransaksiModel {

    private $conn;
    private $table = 'transaksis';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findAll() {

        $query = "SELECT t.*, 
                         a.username AS nama_pengguna,
                         j.asal,
                         j.tujuan
                  FROM {$this->table} t
                  LEFT JOIN admins a ON t.admin_id = a.id
                  LEFT JOIN jadwals j ON t.jadwal_id = j.id
                  ORDER BY t.created_at DESC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function findById($id) {

        $query = "SELECT t.*,
                         a.username AS nama_pengguna,
                         j.asal,
                         j.tujuan
                  FROM {$this->table} t
                  LEFT JOIN admins a ON t.admin_id = a.id
                  LEFT JOIN jadwals j ON t.jadwal_id = j.id
                  WHERE t.id = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }

    public function getTotalHariIni() {

        $query = "SELECT SUM(total_harga) AS total
                  FROM {$this->table}
                  WHERE DATE(created_at) = CURDATE()
                  AND status = 'berhasil'";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total'];
    }

    public function getTiketTerjualHariIni() {

        $query = "SELECT COUNT(*) AS total
                  FROM {$this->table}
                  WHERE DATE(created_at) = CURDATE()
                  AND status = 'berhasil'";

        $stmt = $this->conn->prepare($query)
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();

        return $row['total'];
    }
}