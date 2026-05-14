<?php

class OperatorModel {
    private $conn;

    private $tableBus = 'bus';
    private $tableJadwal = 'jadwal';
    private $tablePemesanan = 'pemesanan';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllBus() {

        $query = 'SELECT * FROM ' . $this->tableBus . '
                  ORDER BY id_bus DESC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function getAllJadwal() {

        $query = 'SELECT * FROM ' . $this->tableJadwal . '
                  ORDER BY id_jadwal DESC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function getAllPemesanan() {

        $query = 'SELECT * FROM ' . $this->tablePemesanan . '
                  ORDER BY id_pemesanan DESC';

        $stmt = $this->conn->prepare($query);

        $stmt->execute();

        return $stmt;
    }

    public function tambahBus($nama_bus, $plat_nomor) {

        $query = 'INSERT INTO ' . $this->tableBus . '
                  (nama_bus, plat_nomor)
                  VALUES (:nama_bus, :plat_nomor)';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':nama_bus', $nama_bus);
        $stmt->bindParam(':plat_nomor', $plat_nomor);

        return $stmt->execute();
    }

    public function hapusBus($id_bus) {

        $query = 'DELETE FROM ' . $this->tableBus . '
                  WHERE id_bus = :id_bus';

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id_bus', $id_bus);

        return $stmt->execute();
    }
}

?>