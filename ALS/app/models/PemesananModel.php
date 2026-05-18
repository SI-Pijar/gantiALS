<?php

class PemesananModel {
    private $conn;
    private $table = 'pemesanans';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function buatPemesanan($id_jadwal, $nama, $email, $telepon, $jumlah, $total, $kursi_dipesan) {
        $query = "INSERT INTO " . $this->table . " 
                  (id_jadwal, nama_pemesan, email, telepon, jumlah_kursi, kursi_dipesan, total_harga, status_pembayaran, created_at) 
                  VALUES (:id_jadwal, :nama, :email, :telepon, :jumlah, :kursi_dipesan, :total, 'pending', NOW())";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_jadwal', $id_jadwal);
        $stmt->bindParam(':nama', $nama);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':telepon', $telepon);
        $stmt->bindParam(':jumlah', $jumlah);
        $stmt->bindParam(':kursi_dipesan', $kursi_dipesan);
        $stmt->bindParam(':total', $total);

        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        }
        return false;
    }

    public function getPemesananById($id) {
        $query = "SELECT p.*, j.asal, j.tujuan, j.tanggal, j.jam_berangkat 
                  FROM " . $this->table . " p
                  JOIN jadwals j ON p.id_jadwal = j.id
                  WHERE p.id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getKursiTerisi($id_jadwal) {
        $query = "SELECT kursi_dipesan FROM " . $this->table . " WHERE id_jadwal = :id_jadwal AND status_pembayaran != 'batal'";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id_jadwal', $id_jadwal);
        $stmt->execute();
        
        $terisi = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($row['kursi_dipesan'])) {
                $kursiArray = explode(',', $row['kursi_dipesan']);
                foreach ($kursiArray as $k) {
                    $terisi[] = trim($k);
                }
            }
        }
        return $terisi;
    }

    public function updateStatus($id, $status) {
        $query = "UPDATE " . $this->table . " SET status_pembayaran = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}