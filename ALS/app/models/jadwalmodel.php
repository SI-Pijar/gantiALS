<?php

class JadwalModel {

    private $conn;
    private $table = 'jadwals';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function findAktif() {

        $query = "SELECT * FROM {$this->table}
                  WHERE status = 'aktif'
                  ORDER BY tanggal ASC, jam_berangkat ASC";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function findByRute($asal, $tujuan, $tanggal) {

        $query = "SELECT * FROM {$this->table}
                  WHERE asal = ?
                  AND tujuan = ?
                  AND tanggal = ?
                  AND status = 'aktif'";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param('sss', $asal, $tujuan, $tanggal);
        $stmt->execute();
        $result = $stmt->get_result();
        $rows = [];

        while ($row = $result->fetch_assoc()) {
            $rows[] = $row;
        }

        return $rows;
    }

    public function kurangiKursi($id, $jumlah = 1) {

        $query = "UPDATE {$this->table}
                  SET kursi_tersedia = kursi_tersedia - ?
                  WHERE id = ?";

        $stmt = $this->conn->prepare($query);

        $stmt->bind_param('ii', $jumlah, $id);

        return $stmt->execute();
    }
}