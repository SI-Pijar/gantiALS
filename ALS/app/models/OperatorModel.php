<?php
class OperatorModel {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getJadwalHariIni($operator_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM jadwal WHERE tanggal = CURDATE() AND operator_id = ?");
        $stmt->execute([$operator_id]);
        return $stmt->fetchColumn();
    }

    public function getPenumpangTerverifikasi($operator_id) {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM pemesanan p
             JOIN jadwal j ON p.id_jadwal = j.id
             WHERE j.operator_id = ? AND p.status_verifikasi = 'Terverifikasi'"
        );
        $stmt->execute([$operator_id]);
        return $stmt->fetchColumn();
    }

    public function getPenumpangBelumVerifikasi($operator_id) {
        $stmt = $this->conn->prepare(
            "SELECT COUNT(*) FROM pemesanan p
             JOIN jadwal j ON p.id_jadwal = j.id
             WHERE j.operator_id = ? AND p.status_verifikasi = 'Belum'"
        );
        $stmt->execute([$operator_id]);
        return $stmt->fetchColumn();
    }

    public function getBusAktif($operator_id) {
        $stmt = $this->conn->prepare("SELECT COUNT(*) FROM bus WHERE status_bus = 'Aktif' AND operator_id = ?");
        $stmt->execute([$operator_id]);
        return $stmt->fetchColumn();
    }

    public function getPemesananTerbaru($operator_id, $limit = 5) {
        $stmt = $this->conn->prepare(
            "SELECT p.*,
             CONCAT('ALS-', LPAD(p.id, 5, '0')) AS kode_booking,
             p.nama_pemesan AS nama_penumpang,
             p.kursi_dipesan AS nomor_kursi,
             j.asal, j.tujuan, j.tanggal, j.jam_berangkat, b.no_polisi
             FROM pemesanan p
             JOIN jadwal j ON p.id_jadwal = j.id
             LEFT JOIN bus b ON j.bus_id = b.id
             WHERE j.operator_id = ?
             ORDER BY p.tanggal_pesan DESC LIMIT ?"
        );
        $stmt->bindValue(1, $operator_id, PDO::PARAM_INT);
        $stmt->bindValue(2, (int)$limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAllBus($operator_id) {
        $stmt = $this->conn->prepare("SELECT * FROM bus WHERE operator_id = ? ORDER BY id DESC");
        $stmt->execute([$operator_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBusById($id, $operator_id) {
        $stmt = $this->conn->prepare("SELECT * FROM bus WHERE id = ? AND operator_id = ? LIMIT 1");
        $stmt->execute([$id, $operator_id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getBusAktifByOperator($operator_id) {
        $stmt = $this->conn->prepare("SELECT * FROM bus WHERE status_bus = 'Aktif' AND operator_id = ?");
        $stmt->execute([$operator_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahBus($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO bus (no_polisi, kelas_bus, kapasitas, status_bus, operator_id) VALUES (?, ?, ?, ?, ?)"
        );
        return $stmt->execute([$data['no_polisi'], $data['kelas_bus'], $data['kapasitas'], $data['status_bus'], $data['operator_id']]);
    }

    public function updateBus($id, $operator_id, $data) {
        $stmt = $this->conn->prepare(
            "UPDATE bus SET no_polisi = ?, kelas_bus = ?, kapasitas = ?, status_bus = ? WHERE id = ? AND operator_id = ?"
        );
        return $stmt->execute([$data['no_polisi'], $data['kelas_bus'], $data['kapasitas'], $data['status_bus'], $id, $operator_id]);
    }

    public function hapusBus($id, $operator_id) {
        $stmt = $this->conn->prepare("DELETE FROM bus WHERE id = ? AND operator_id = ?");
        return $stmt->execute([$id, $operator_id]);
    }

    public function getAllJadwal($operator_id) {
        $stmt = $this->conn->prepare(
            "SELECT j.*, b.no_polisi, b.kelas_bus
             FROM jadwal j LEFT JOIN bus b ON j.bus_id = b.id
             WHERE j.operator_id = ?
             ORDER BY j.tanggal DESC, j.jam_berangkat DESC"
        );
        $stmt->execute([$operator_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function tambahJadwal($data) {
        $stmt = $this->conn->prepare(
            "INSERT INTO jadwal (bus_id, asal, tujuan, tanggal, jam_berangkat, harga, kursi_tersedia, operator_id, status)
             VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'pending')"
        );
        return $stmt->execute([
            $data['bus_id'], $data['asal'], $data['tujuan'], $data['tanggal'],
            $data['jam_berangkat'], $data['harga'], $data['kursi_tersedia'], $data['operator_id'],
        ]);
    }

    public function updateJadwal($id, $operator_id, $data) {
        $stmt = $this->conn->prepare(
            "UPDATE jadwal SET bus_id = ?, asal = ?, tujuan = ?, tanggal = ?,
             jam_berangkat = ?, harga = ?, kursi_tersedia = ?, status = 'pending'
             WHERE id = ? AND operator_id = ?"
        );
        return $stmt->execute([
            $data['bus_id'], $data['asal'], $data['tujuan'], $data['tanggal'],
            $data['jam_berangkat'], $data['harga'], $data['kursi_tersedia'], $id, $operator_id,
        ]);
    }

    public function hapusJadwal($id, $operator_id) {
        $stmt = $this->conn->prepare("DELETE FROM jadwal WHERE id = ? AND operator_id = ?");
        return $stmt->execute([$id, $operator_id]);
    }

    public function getAllPemesanan($operator_id) {
        $stmt = $this->conn->prepare(
            "SELECT p.*,
             CONCAT('ALS-', LPAD(p.id, 5, '0')) AS kode_booking,
             p.nama_pemesan AS nama_penumpang,
             p.kursi_dipesan AS nomor_kursi,
             j.asal, j.tujuan, j.tanggal, j.jam_berangkat
             FROM pemesanan p
             JOIN jadwal j ON p.id_jadwal = j.id
             WHERE j.operator_id = ?
             ORDER BY p.tanggal_pesan DESC"
        );
        $stmt->execute([$operator_id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStatusVerifikasi($id, $operator_id, $status) {
        $stmt = $this->conn->prepare(
            "UPDATE pemesanan p JOIN jadwal j ON p.id_jadwal = j.id
             SET p.status_verifikasi = ?
             WHERE p.id = ? AND j.operator_id = ?"
        );
        return $stmt->execute([$status, $id, $operator_id]);
    }

    public function findOperatorByEmailOrUsername($credential) {
        $stmt = $this->conn->prepare("SELECT * FROM operators WHERE email = ? OR username = ? LIMIT 1");
        $stmt->execute([$credential, $credential]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOperatorById($id) {
        $stmt = $this->conn->prepare("SELECT id, username, email, nama FROM operators WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPasswordOperatorById($id) {
        $stmt = $this->conn->prepare("SELECT password FROM operators WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['password'] : null;
    }

    public function updateProfilOperator($id, $nama) {
        $stmt = $this->conn->prepare("UPDATE operators SET nama = :nama WHERE id = :id");
        return $stmt->execute([':nama' => $nama, ':id' => $id]);
    }

    public function updatePasswordOperator($id, $password_baru) {
        $stmt = $this->conn->prepare("UPDATE operators SET password = :password WHERE id = :id");
        return $stmt->execute([
            ':password' => password_hash($password_baru, PASSWORD_BCRYPT, ['cost' => 12]),
            ':id' => $id,
        ]);
    }

    public function getAllOperators() {
        $stmt = $this->conn->prepare("SELECT id, username, email, nama, created_at FROM operators ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOperatorByIdAdmin($id) {
        $stmt = $this->conn->prepare("SELECT id, username, email, nama FROM operators WHERE id = ? LIMIT 1");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function emailOperatorExists($email, $exclude_id = null) {
        if ($exclude_id) {
            $stmt = $this->conn->prepare("SELECT id FROM operators WHERE email = ? AND id != ? LIMIT 1");
            $stmt->execute([$email, $exclude_id]);
        } else {
            $stmt = $this->conn->prepare("SELECT id FROM operators WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
        }
        return $stmt->fetch() !== false;
    }

    public function usernameOperatorExists($username, $exclude_id = null) {
        if ($exclude_id) {
            $stmt = $this->conn->prepare("SELECT id FROM operators WHERE username = ? AND id != ? LIMIT 1");
            $stmt->execute([$username, $exclude_id]);
        } else {
            $stmt = $this->conn->prepare("SELECT id FROM operators WHERE username = ? LIMIT 1");
            $stmt->execute([$username]);
        }
        return $stmt->fetch() !== false;
    }

    public function createOperator($username, $email, $password, $nama) {
        $stmt = $this->conn->prepare(
            "INSERT INTO operators (username, email, password, nama) VALUES (:username, :email, :password, :nama)"
        );
        return $stmt->execute([
            ':username' => $username,
            ':email' => $email,
            ':password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
            ':nama' => $nama,
        ]);
    }

    public function updateOperator($id, $data) {
        $sets = [];
        $params = [':id' => $id];

        foreach (['nama', 'email', 'username'] as $field) {
            if (isset($data[$field])) {
                $sets[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $sets[] = 'password = :password';
            $params[':password'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        }

        if (empty($sets)) return false;

        $stmt = $this->conn->prepare("UPDATE operators SET " . implode(', ', $sets) . " WHERE id = :id");
        return $stmt->execute($params);
    }

    public function deleteOperator($id) {
        $stmt = $this->conn->prepare("DELETE FROM operators WHERE id = ?");
        return $stmt->execute([$id]);
    }
}
