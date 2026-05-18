<?php
class JadwalModel {
    private $conn;
    private $table = 'jadwals';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getDistinctAsal() {
        $query = 'SELECT DISTINCT asal FROM ' . $this->table . ' WHERE status = "aktif" ORDER BY asal ASC';
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistinctTujuan() {
        $query = 'SELECT DISTINCT tujuan FROM ' . $this->table . ' WHERE status = "aktif" ORDER BY tujuan ASC';
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function searchJadwal($asal, $tujuan, $tanggal) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE status = "aktif"';
        $params = [];
        if (!empty($asal)) {
            $query .= ' AND asal = :asal';
            $params[':asal'] = $asal;
        }
        if (!empty($tujuan)) {
            $query .= ' AND tujuan = :tujuan';
            $params[':tujuan'] = $tujuan;
        }
        if (!empty($tanggal)) {
            $query .= ' AND tanggal = :tanggal';
            $params[':tanggal'] = $tanggal;
        }
        $query .= ' ORDER BY tanggal ASC, jam_berangkat ASC';
        $stmt = $this->conn->prepare($query);
        foreach ($params as $key => $val) {
            $stmt->bindValue($key, $val);
        }
        $stmt->execute();
        return $stmt;
    }

    public function updateKursi($id, $jumlah) {
        $query = 'UPDATE ' . $this->table . ' SET kursi_tersedia = kursi_tersedia - :jumlah WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':jumlah', $jumlah, PDO::PARAM_INT);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function getAllJadwal() {
        $query = 'SELECT * FROM ' . $this->table . ' ORDER BY tanggal DESC, jam_berangkat ASC';
        $stmt  = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getJadwalById($id) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE id = :id LIMIT 1';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createJadwal($asal, $tujuan, $tanggal, $jam_berangkat, $jam_tiba, $harga, $kursi, $status) {
        $query = 'INSERT INTO ' . $this->table . '
                  (asal, tujuan, tanggal, jam_berangkat, jam_tiba, harga, kursi_tersedia, status)
                  VALUES (:asal, :tujuan, :tanggal, :jam_berangkat, :jam_tiba, :harga, :kursi, :status)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':asal',          $asal);
        $stmt->bindParam(':tujuan',        $tujuan);
        $stmt->bindParam(':tanggal',       $tanggal);
        $stmt->bindParam(':jam_berangkat', $jam_berangkat);
        $stmt->bindParam(':jam_tiba',      $jam_tiba);
        $stmt->bindParam(':harga',         $harga);
        $stmt->bindParam(':kursi',         $kursi);
        $stmt->bindParam(':status',        $status);
        return $stmt->execute();
    }

    public function updateJadwal($id, $asal, $tujuan, $tanggal, $jam_berangkat, $jam_tiba, $harga, $kursi, $status) {
        $query = 'UPDATE ' . $this->table . '
                  SET asal = :asal, tujuan = :tujuan, tanggal = :tanggal,
                      jam_berangkat = :jam_berangkat, jam_tiba = :jam_tiba,
                      harga = :harga, kursi_tersedia = :kursi, status = :status
                  WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',            $id);
        $stmt->bindParam(':asal',          $asal);
        $stmt->bindParam(':tujuan',        $tujuan);
        $stmt->bindParam(':tanggal',       $tanggal);
        $stmt->bindParam(':jam_berangkat', $jam_berangkat);
        $stmt->bindParam(':jam_tiba',      $jam_tiba);
        $stmt->bindParam(':harga',         $harga);
        $stmt->bindParam(':kursi',         $kursi);
        $stmt->bindParam(':status',        $status);
        return $stmt->execute();
    }

    public function deleteJadwal($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
