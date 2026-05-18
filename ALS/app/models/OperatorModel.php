<?php

class OperatorModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getJadwalHariIni($operator_id) {
        $query = "SELECT COUNT(*) FROM jadwal WHERE tanggal_keberangkatan = CURDATE() AND operator_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$operator_id]);
        return $stmt->fetchColumn();
    }

    public function getPenumpangTerverifikasi($operator_id) {
        $query = "SELECT COUNT(*) FROM pemesanan p 
                  JOIN jadwal j ON p.jadwal_id = j.id 
                  WHERE j.operator_id = ? AND p.status_verifikasi = 'Terverifikasi'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$operator_id]);
        return $stmt->fetchColumn();
    }

    public function getPenumpangBelumVerifikasi($operator_id) {
        $query = "SELECT COUNT(*) FROM pemesanan p 
                  JOIN jadwal j ON p.jadwal_id = j.id 
                  WHERE j.operator_id = ? AND p.status_verifikasi = 'Belum'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$operator_id]);
        return $stmt->fetchColumn();
    }

    public function getBusAktif($operator_id) {
        $query = "SELECT COUNT(*) FROM bus WHERE status_bus = 'Aktif' AND operator_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$operator_id]);
        return $stmt->fetchColumn();
    }

    public function getPemesananTerbaru($operator_id, $limit = 5) {
        $query = "SELECT p.*, j.asal, j.tujuan, j.tanggal_keberangkatan, j.jam_keberangkatan, b.no_polisi 
                  FROM pemesanan p 
                  JOIN jadwal j ON p.jadwal_id = j.id 
                  JOIN bus b ON j.bus_id = b.id 
                  WHERE j.operator_id = ? 
                  ORDER BY p.created_at DESC LIMIT ?";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(1, $operator_id, PDO::PARAM_INT);
        $stmt->bindParam(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBus($operator_id) {
        $query = "SELECT * FROM bus WHERE operator_id = ? ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$operator_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusById($id, $operator_id) {
        $query = "SELECT * FROM bus WHERE id = ? AND operator_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id, $operator_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function tambahBus($data) {
        $query = "INSERT INTO bus (no_polisi, kelas_bus, kapasitas, status_bus, operator_id) 
                  VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['no_polisi'],
            $data['kelas_bus'],
            $data['kapasitas'],
            $data['status_bus'],
            $data['operator_id']
        ]);
    }

    public function updateBus($id, $operator_id, $data) {
        $query = "UPDATE bus SET no_polisi = ?, kelas_bus = ?, kapasitas = ?, status_bus = ? 
                  WHERE id = ? AND operator_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['no_polisi'],
            $data['kelas_bus'],
            $data['kapasitas'],
            $data['status_bus'],
            $id,
            $operator_id
        ]);
    }
    
    public function hapusBus($id, $operator_id) {
        $query = "DELETE FROM bus WHERE id = ? AND operator_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id, $operator_id]);
    }

    public function getBusKelasOptions() {
        $query = "SELECT DISTINCT kelas_bus FROM bus";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
    
    public function getBusAktifByOperator($operator_id) {
        $query = "SELECT * FROM bus WHERE status_bus = 'Aktif' AND operator_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$operator_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllJadwal($operator_id) {
        $query = "SELECT j.*, b.no_polisi, b.kelas_bus 
                  FROM jadwal j JOIN bus b ON j.bus_id = b.id 
                  WHERE j.operator_id = ? 
                  ORDER BY j.tanggal_keberangkatan DESC, j.jam_keberangkatan DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$operator_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getJadwalById($id, $operator_id) {
        $query = "SELECT * FROM jadwal WHERE id = ? AND operator_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id, $operator_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function tambahJadwal($data) {
        $query = "INSERT INTO jadwal (bus_id, asal, tujuan, tanggal_keberangkatan, jam_keberangkatan, harga, kursi_tersedia, operator_id) 
                  VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['bus_id'],
            $data['asal'],
            $data['tujuan'],
            $data['tanggal_keberangkatan'],
            $data['jam_keberangkatan'],
            $data['harga'],
            $data['kursi_tersedia'],
            $data['operator_id']
        ]);
    }

    public function updateJadwal($id, $operator_id, $data) {
        $query = "UPDATE jadwal SET bus_id = ?, asal = ?, tujuan = ?, tanggal_keberangkatan = ?, 
                  jam_keberangkatan = ?, harga = ?, kursi_tersedia = ? 
                  WHERE id = ? AND operator_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([
            $data['bus_id'],
            $data['asal'],
            $data['tujuan'],
            $data['tanggal_keberangkatan'],
            $data['jam_keberangkatan'],
            $data['harga'],
            $data['kursi_tersedia'],
            $id,
            $operator_id
        ]);
    }
    
    public function hapusJadwal($id, $operator_id) {
        $query = "DELETE FROM jadwal WHERE id = ? AND operator_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$id, $operator_id]);
    }

    public function getAllPemesanan($operator_id) {
        $query = "SELECT p.*, j.asal, j.tujuan, j.tanggal_keberangkatan, j.jam_keberangkatan 
                  FROM pemesanan p 
                  JOIN jadwal j ON p.jadwal_id = j.id 
                  WHERE j.operator_id = ? 
                  ORDER BY p.created_at DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$operator_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPemesananById($id, $operator_id) {
        $query = "SELECT p.*, j.asal, j.tujuan, j.tanggal_keberangkatan, j.jam_keberangkatan, b.no_polisi, b.kelas_bus 
                  FROM pemesanan p 
                  JOIN jadwal j ON p.jadwal_id = j.id 
                  JOIN bus b ON j.bus_id = b.id
                  WHERE p.id = ? AND j.operator_id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id, $operator_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateStatusVerifikasi($id, $operator_id, $status) {
        $query = "UPDATE pemesanan p JOIN jadwal j ON p.jadwal_id = j.id 
                  SET p.status_verifikasi = ? 
                  WHERE p.id = ? AND j.operator_id = ?";
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$status, $id, $operator_id]);
    }

    public function getPemesananByStatus($operator_id, $status) {
        $query = "SELECT p.*, j.asal, j.tujuan FROM pemesanan p JOIN jadwal j ON p.jadwal_id = j.id 
                  WHERE j.operator_id = ? AND p.status_verifikasi = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$operator_id, $status]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>