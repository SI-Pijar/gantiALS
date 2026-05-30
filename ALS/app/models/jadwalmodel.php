<?php
class JadwalModel {
    private $conn;
    private $table = 'jadwal';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getDistinctAsal() {
        $stmt = $this->conn->prepare("SELECT DISTINCT asal FROM {$this->table} WHERE status = 'aktif' ORDER BY asal ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistinctTujuan() {
        $stmt = $this->conn->prepare("SELECT DISTINCT tujuan FROM {$this->table} WHERE status = 'aktif' ORDER BY tujuan ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchJadwal($asal, $tujuan, $tanggal) {
        $query = "SELECT j.*, b.kelas_bus, b.no_polisi, b.kapasitas
                  FROM {$this->table} j
                  LEFT JOIN bus b ON j.bus_id = b.id
                  WHERE j.status = 'aktif'";
        $params = [];

        if (!empty($asal)) {
            $query .= ' AND j.asal = :asal';
            $params[':asal'] = $asal;
        }
        if (!empty($tujuan)) {
            $query .= ' AND j.tujuan = :tujuan';
            $params[':tujuan'] = $tujuan;
        }
        if (!empty($tanggal)) {
            $query .= ' AND j.tanggal = :tanggal';
            $params[':tanggal'] = $tanggal;
        }

        $query .= ' ORDER BY j.tanggal ASC, j.jam_berangkat ASC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllJadwal() {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} ORDER BY tanggal DESC, jam_berangkat ASC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function countJadwal() {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM {$this->table}");
        $stmt->execute();
        return (int)$stmt->fetchColumn();
    }

    public function getJadwalById($id) {
        $stmt = $this->conn->prepare(
            "SELECT j.*, b.kelas_bus, b.no_polisi, b.kapasitas
             FROM {$this->table} j
             LEFT JOIN bus b ON j.bus_id = b.id
             WHERE j.id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createJadwal($asal, $tujuan, $tanggal, $jam_berangkat, $harga, $kursi, $status) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table}
             (asal, tujuan, tanggal, jam_berangkat, harga, kursi_tersedia, status)
             VALUES (:asal, :tujuan, :tanggal, :jam_berangkat, :harga, :kursi, :status)"
        );
        return $stmt->execute([
            ':asal' => $asal,
            ':tujuan' => $tujuan,
            ':tanggal' => $tanggal,
            ':jam_berangkat' => $jam_berangkat,
            ':harga' => $harga,
            ':kursi' => $kursi,
            ':status' => $status,
        ]);
    }

    public function updateJadwal($id, $asal, $tujuan, $tanggal, $jam_berangkat, $harga, $kursi, $status) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table}
             SET asal = :asal, tujuan = :tujuan, tanggal = :tanggal,
                 jam_berangkat = :jam_berangkat, harga = :harga,
                 kursi_tersedia = :kursi, status = :status
             WHERE id = :id"
        );
        return $stmt->execute([
            ':id' => $id,
            ':asal' => $asal,
            ':tujuan' => $tujuan,
            ':tanggal' => $tanggal,
            ':jam_berangkat' => $jam_berangkat,
            ':harga' => $harga,
            ':kursi' => $kursi,
            ':status' => $status,
        ]);
    }

    public function updateKursi($id, $jumlah) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table} SET kursi_tersedia = kursi_tersedia - :jumlah WHERE id = :id"
        );
        return $stmt->execute([':jumlah' => $jumlah, ':id' => $id]);
    }

    public function updateStatusJadwal($id, $status) {
        $stmt = $this->conn->prepare("UPDATE {$this->table} SET status = :status WHERE id = :id");
        return $stmt->execute([':status' => $status, ':id' => $id]);
    }

    public function deleteJadwal($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => $id]);
    }
}
