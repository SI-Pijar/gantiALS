<?php
class TransaksiModel {
    private $conn;
    private $table = 'pemesanan';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllTransaksi() {
        $stmt = $this->conn->prepare(
            "SELECT p.*, j.asal, j.tujuan
             FROM {$this->table} p
             LEFT JOIN jadwal j ON p.id_jadwal = j.id
             ORDER BY p.tanggal_pesan DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTransaksiById($id) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, j.asal, j.tujuan, j.tanggal, j.jam_berangkat
             FROM {$this->table} p
             LEFT JOIN jadwal j ON p.id_jadwal = j.id
             WHERE p.id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getTotalPendapatanHariIni() {
        $stmt = $this->conn->prepare(
            "SELECT COALESCE(SUM(total_harga), 0) AS total
             FROM {$this->table}
             WHERE DATE(tanggal_pesan) = CURDATE()
               AND status_pembayaran IN ('Lunas', 'berhasil')"
        );
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTiketTerjualHariIni() {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) AS total
             FROM {$this->table}
             WHERE DATE(tanggal_pesan) = CURDATE()
               AND status_pembayaran IN ('Lunas', 'berhasil')"
        );
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getTransaksiFiltered($filter_status, $filter_dari = '', $filter_sampai = '') {
        $query  = "SELECT p.*, j.asal, j.tujuan
                   FROM {$this->table} p
                   LEFT JOIN jadwal j ON p.id_jadwal = j.id
                   WHERE 1=1";
        $params = [];

        if (!empty($filter_dari)) {
            $query .= ' AND DATE(p.tanggal_pesan) >= :dari';
            $params[':dari'] = $filter_dari;
        }
        if (!empty($filter_sampai)) {
            $query .= ' AND DATE(p.tanggal_pesan) <= :sampai';
            $params[':sampai'] = $filter_sampai;
        }
        if (!empty($filter_status)) {
            $query .= ' AND p.status_pembayaran = :status';
            $params[':status'] = $filter_status;
        }

        $query .= ' ORDER BY p.tanggal_pesan DESC';

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
