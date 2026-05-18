<?php
class TransaksiModel {
    private $conn;
    private $table = 'transaksis';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllTransaksi() {
        $query = 'SELECT t.*, a.username AS nama_Penumpang, j.asal, j.tujuan
                  FROM ' . $this->table . ' t
                  LEFT JOIN admins  a ON t.admin_id  = a.id
                  LEFT JOIN jadwals j ON t.jadwal_id = j.id
                  ORDER BY t.created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getTransaksiById($id) {
        $query = 'SELECT t.*, a.username AS nama_Penumpang, a.nama_lengkap,
                         j.asal, j.tujuan, j.tanggal, j.jam_berangkat, j.jam_tiba
                  FROM ' . $this->table . ' t
                  LEFT JOIN admins  a ON t.admin_id  = a.id
                  LEFT JOIN jadwals j ON t.jadwal_id = j.id
                  WHERE t.id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalPendapatanHariIni() {
        $query = "SELECT COALESCE(SUM(total_harga), 0) AS total
                  FROM " . $this->table . "
                  WHERE DATE(created_at) = CURDATE() AND status = 'berhasil'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function getTiketTerjualHariIni() {
        $query = "SELECT COUNT(*) AS total
                  FROM " . $this->table . "
                  WHERE DATE(created_at) = CURDATE() AND status = 'berhasil'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function filterTransaksi($dari, $sampai, $status) {
        $query = 'SELECT t.*, a.username AS nama_Penumpang, j.asal, j.tujuan
                  FROM ' . $this->table . ' t
                  LEFT JOIN admins  a ON t.admin_id  = a.id
                  LEFT JOIN jadwals j ON t.jadwal_id = j.id
                  WHERE 1=1';
        if ($dari)   $query .= " AND DATE(t.created_at) >= :dari";
        if ($sampai) $query .= " AND DATE(t.created_at) <= :sampai";
        if ($status) $query .= " AND t.status = :status";
        $query .= ' ORDER BY t.created_at DESC';

        $stmt = $this->conn->prepare($query);
        if ($dari)   $stmt->bindParam(':dari',   $dari);
        if ($sampai) $stmt->bindParam(':sampai', $sampai);
        if ($status) $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $stmt;
    }
}
