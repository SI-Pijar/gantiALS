<?php
class PemesananModel {
    private $conn;
    private $table = 'pemesanan';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function buatPemesanan($jadwal_id, $nama, $email, $telepon, $jumlah, $total, $kursi_dipesan) {
        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table}
             (id_jadwal, nama_pemesan, email, telepon, jumlah, kursi_dipesan, total_harga, status_pembayaran, tanggal_pesan)
             VALUES (:jadwal_id, :nama, :email, :telepon, :jumlah, :kursi_dipesan, :total, 'pending', NOW())"
        );
        $stmt->execute([
            ':jadwal_id' => $jadwal_id,
            ':nama' => $nama,
            ':email' => $email,
            ':telepon' => $telepon,
            ':jumlah' => $jumlah,
            ':kursi_dipesan' => $kursi_dipesan,
            ':total' => $total,
        ]);
        return $stmt->rowCount() ? $this->conn->lastInsertId() : false;
    }

    public function getPemesananById($id) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, j.asal, j.tujuan, j.tanggal, j.jam_berangkat
             FROM {$this->table} p
             JOIN jadwal j ON p.id_jadwal = j.id
             WHERE p.id = :id"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPemesananByEmail($email) {
        $stmt = $this->conn->prepare(
            "SELECT p.*, j.asal, j.tujuan, j.tanggal, j.jam_berangkat
             FROM {$this->table} p
             LEFT JOIN jadwal j ON p.id_jadwal = j.id
             WHERE p.email = :email
             ORDER BY p.tanggal_pesan DESC"
        );
        $stmt->execute([':email' => $email]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getKursiTerisi($jadwal_id) {
        $stmt = $this->conn->prepare(
            "SELECT kursi_dipesan FROM {$this->table}
             WHERE id_jadwal = :jadwal_id AND status_pembayaran != 'batal'"
        );
        $stmt->execute([':jadwal_id' => $jadwal_id]);

        $terisi = [];
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            if (!empty($row['kursi_dipesan'])) {
                foreach (explode(',', $row['kursi_dipesan']) as $k) {
                    $terisi[] = trim($k);
                }
            }
        }
        return $terisi;
    }

    public function updateStatusPembayaran($id, $status, $metode_pembayaran) {
        $stmt = $this->conn->prepare(
            "UPDATE {$this->table}
             SET status_pembayaran = :status, metode_pembayaran = :metode
             WHERE id = :id"
        );
        return $stmt->execute([':status' => $status, ':metode' => $metode_pembayaran, ':id' => $id]);
    }
}
