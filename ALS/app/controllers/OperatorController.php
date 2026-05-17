<?php

require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/OperatorModel.php';

class OperatorController {
    private $db;
    private $operatorModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $database = new Database();
        $this->db = $database->connect();
        $this->operatorModel = new OperatorModel($this->db);
    }

    private function checkSession() {
        if (!isset($_SESSION['operator_id'])) {
            header('Location: /gantiALS/ALS/index.php?controller=operator&action=login');
            exit;
        }
    }

    public function dashboard() {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];

        $jadwalHariIni = $this->operatorModel->getJadwalHariIni($operator_id);
        $penumpangTerverifikasi = $this->operatorModel->getPenumpangTerverifikasi($operator_id);
        $penumpangBelumVerifikasi = $this->operatorModel->getPenumpangBelumVerifikasi($operator_id);
        $busAktif = $this->operatorModel->getBusAktif($operator_id);
        
        $pemesananTerbaru = $this->operatorModel->getPemesananTerbaru($operator_id, 5);

        require_once __DIR__ . '/../views/operator/operatordashboard.php';
    }

    public function bilList() {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];
        
        $busList = $this->operatorModel->getAllBus($operator_id);

        require_once __DIR__ . '/../views/operator/operatorbil.php';
    }

    public function bilAdd() {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'no_polisi' => trim($_POST['no_polisi'] ?? ''),
                'kelas_bus' => trim($_POST['kelas_bus'] ?? ''),
                'kapasitas' => filter_var($_POST['kapasitas'] ?? 0, FILTER_VALIDATE_INT),
                'status_bus' => trim($_POST['status_bus'] ?? 'Aktif'),
                'operator_id' => $operator_id
            ];

            if (empty($data['no_polisi']) || empty($data['kelas_bus']) || $data['kapasitas'] === false || $data['kapasitas'] <= 0) {
                $_SESSION['error'] = "Semua field harus diisi dengan format yang benar!";
            } else {
                try {
                    if ($this->operatorModel->tambahBus($data)) {
                        $_SESSION['success'] = "Bus berhasil ditambahkan.";
                    } else {
                        $_SESSION['error'] = "Gagal menambahkan bus.";
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = "Terjadi kesalahan sistem.";
                }
            }
            header('Location: /gantiALS/ALS/index.php?controller=operator&action=bilList');
            exit;
        }
    }

    public function bilEdit($id) {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'no_polisi' => trim($_POST['no_polisi'] ?? ''),
                'kelas_bus' => trim($_POST['kelas_bus'] ?? ''),
                'kapasitas' => filter_var($_POST['kapasitas'] ?? 0, FILTER_VALIDATE_INT),
                'status_bus' => trim($_POST['status_bus'] ?? 'Aktif')
            ];

            if (empty($data['no_polisi']) || empty($data['kelas_bus']) || $data['kapasitas'] === false || $data['kapasitas'] <= 0) {
                $_SESSION['error'] = "Semua field harus diisi dengan format yang benar!";
            } else {
                try {
                    if ($this->operatorModel->updateBus($id, $operator_id, $data)) {
                        $_SESSION['success'] = "Bus berhasil diupdate.";
                    } else {
                        $_SESSION['error'] = "Gagal mengupdate bus.";
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = "Terjadi kesalahan sistem.";
                }
            }
            header('Location: /gantiALS/ALS/index.php?controller=operator&action=bilList');
            exit;
        }
    }

    public function bilDelete($id) {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];

        try {
            if ($this->operatorModel->hapusBus($id, $operator_id)) {
                $_SESSION['success'] = "Bus berhasil dihapus.";
            } else {
                $_SESSION['error'] = "Gagal menghapus bus.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Terjadi kesalahan sistem.";
        }
        header('Location: /gantiALS/ALS/index.php?controller=operator&action=bilList');
        exit;
    }

    public function jadwalList() {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];
        
        $jadwalList = $this->operatorModel->getAllJadwal($operator_id);
        $busListOptions = $this->operatorModel->getBusAktifByOperator($operator_id);

        require_once __DIR__ . '/../views/operator/operatorjadwal.php';
    }

    public function jadwalAdd() {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tanggal_keberangkatan = trim($_POST['tanggal_keberangkatan'] ?? '');
            $harga = filter_var($_POST['harga'] ?? 0, FILTER_VALIDATE_FLOAT);
            $bus_id = filter_var($_POST['bus_id'] ?? 0, FILTER_VALIDATE_INT);
            $kursi_tersedia = filter_var($_POST['kursi_tersedia'] ?? 0, FILTER_VALIDATE_INT);
            $jam_keberangkatan = trim($_POST['jam_keberangkatan'] ?? '');

            if (empty($tanggal_keberangkatan) || strtotime($tanggal_keberangkatan) < strtotime(date('Y-m-d'))) {
                $_SESSION['error'] = "Tanggal keberangkatan tidak valid atau di masa lalu!";
            } elseif ($harga === false || $harga <= 0) {
                $_SESSION['error'] = "Harga harus lebih dari 0 dan berupa angka!";
            } elseif ($bus_id === false || $bus_id <= 0) {
                $_SESSION['error'] = "Bus harus dipilih!";
            } elseif ($kursi_tersedia === false || $kursi_tersedia < 0) {
                $_SESSION['error'] = "Jumlah kursi tidak valid!";
            } elseif (empty($jam_keberangkatan) || !preg_match('/^(?:2[0-3]|[01][0-9]):[0-5][0-9]$/', $jam_keberangkatan)) {
                $_SESSION['error'] = "Jam keberangkatan tidak valid!";
            } else {
                $data = [
                    'bus_id' => $bus_id,
                    'asal' => trim($_POST['asal'] ?? ''),
                    'tujuan' => trim($_POST['tujuan'] ?? ''),
                    'tanggal_keberangkatan' => $tanggal_keberangkatan,
                    'jam_keberangkatan' => $jam_keberangkatan,
                    'harga' => $harga,
                    'kursi_tersedia' => $kursi_tersedia,
                    'operator_id' => $operator_id
                ];

                if (empty($data['asal']) || empty($data['tujuan'])) {
                     $_SESSION['error'] = "Asal dan tujuan tidak boleh kosong!";
                } else {
                    try {
                        if ($this->operatorModel->tambahJadwal($data)) {
                            $_SESSION['success'] = "Jadwal berhasil ditambahkan.";
                        } else {
                            $_SESSION['error'] = "Gagal menambahkan jadwal.";
                        }
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Terjadi kesalahan sistem.";
                    }
                }
            }
            header('Location: /gantiALS/ALS/index.php?controller=operator&action=jadwalList');
            exit;
        }
    }

    public function jadwalEdit($id) {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $tanggal_keberangkatan = trim($_POST['tanggal_keberangkatan'] ?? '');
            $harga = filter_var($_POST['harga'] ?? 0, FILTER_VALIDATE_FLOAT);
            $bus_id = filter_var($_POST['bus_id'] ?? 0, FILTER_VALIDATE_INT);
            $kursi_tersedia = filter_var($_POST['kursi_tersedia'] ?? 0, FILTER_VALIDATE_INT);
            $jam_keberangkatan = trim($_POST['jam_keberangkatan'] ?? '');

            if (empty($tanggal_keberangkatan) || strtotime($tanggal_keberangkatan) < strtotime(date('Y-m-d'))) {
                $_SESSION['error'] = "Tanggal keberangkatan tidak valid atau di masa lalu!";
            } elseif ($harga === false || $harga <= 0) {
                $_SESSION['error'] = "Harga harus lebih dari 0 dan berupa angka!";
            } elseif ($bus_id === false || $bus_id <= 0) {
                $_SESSION['error'] = "Bus harus dipilih!";
            } elseif ($kursi_tersedia === false || $kursi_tersedia < 0) {
                $_SESSION['error'] = "Jumlah kursi tidak valid!";
            } elseif (empty($jam_keberangkatan) || !preg_match('/^(?:2[0-3]|[01][0-9]):[0-5][0-9](?::[0-5][0-9])?$/', $jam_keberangkatan)) {
                $_SESSION['error'] = "Jam keberangkatan tidak valid!";
            } else {
                $data = [
                    'bus_id' => $bus_id,
                    'asal' => trim($_POST['asal'] ?? ''),
                    'tujuan' => trim($_POST['tujuan'] ?? ''),
                    'tanggal_keberangkatan' => $tanggal_keberangkatan,
                    'jam_keberangkatan' => $jam_keberangkatan,
                    'harga' => $harga,
                    'kursi_tersedia' => $kursi_tersedia
                ];

                if (empty($data['asal']) || empty($data['tujuan'])) {
                     $_SESSION['error'] = "Asal dan tujuan tidak boleh kosong!";
                } else {
                    try {
                        if ($this->operatorModel->updateJadwal($id, $operator_id, $data)) {
                            $_SESSION['success'] = "Jadwal berhasil diupdate.";
                        } else {
                            $_SESSION['error'] = "Gagal mengupdate jadwal.";
                        }
                    } catch (Exception $e) {
                        $_SESSION['error'] = "Terjadi kesalahan sistem.";
                    }
                }
            }
            header('Location: /gantiALS/ALS/index.php?controller=operator&action=jadwalList');
            exit;
        }
    }

    public function jadwalDelete($id) {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];

        try {
            if ($this->operatorModel->hapusJadwal($id, $operator_id)) {
                $_SESSION['success'] = "Jadwal berhasil dihapus.";
            } else {
                $_SESSION['error'] = "Gagal menghapus jadwal.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Terjadi kesalahan sistem.";
        }
        header('Location: /gantiALS/ALS/index.php?controller=operator&action=jadwalList');
        exit;
    }

    public function pemesananList() {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];
        
        $pemesananList = $this->operatorModel->getAllPemesanan($operator_id);

        require_once __DIR__ . '/../views/operator/operatorpemesanan.php';
    }

    public function pemesananVerifikasi($id) {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];

        try {
            if ($this->operatorModel->updateStatusVerifikasi($id, $operator_id, 'Terverifikasi')) {
                $_SESSION['success'] = "Pemesanan berhasil diverifikasi.";
            } else {
                $_SESSION['error'] = "Gagal memverifikasi pemesanan.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Terjadi kesalahan sistem.";
        }
        header('Location: /gantiALS/ALS/index.php?controller=operator&action=pemesananList');
        exit;
    }

    public function pemesananTolak($id) {
        $this->checkSession();
        $operator_id = $_SESSION['operator_id'];

        try {
            if ($this->operatorModel->updateStatusVerifikasi($id, $operator_id, 'Ditolak')) {
                $_SESSION['success'] = "Pemesanan berhasil ditolak.";
            } else {
                $_SESSION['error'] = "Gagal menolak pemesanan.";
            }
        } catch (Exception $e) {
            $_SESSION['error'] = "Terjadi kesalahan sistem.";
        }
        header('Location: /gantiALS/ALS/index.php?controller=operator&action=pemesananList');
        exit;
    }

    public function login() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (isset($_SESSION['operator_id'])) {
            header('Location: /gantiALS/ALS/index.php?controller=operator&action=dashboard');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
            $password = $_POST['password'] ?? '';
            
            if (!$email) {
                 $_SESSION['error'] = "Format email tidak valid.";
            } elseif (empty($password)) {
                 $_SESSION['error'] = "Password tidak boleh kosong.";
            } else {
                try {
                    $query = "SELECT * FROM operators WHERE email = ?";
                    $stmt = $this->db->prepare($query);
                    $stmt->execute([$email]);
                    $operator = $stmt->fetch(PDO::FETCH_ASSOC);

                    if ($operator && password_verify($password, $operator['password_hash'])) {
                        $_SESSION['operator_id'] = $operator['id'];
                        $_SESSION['nama_operator'] = $operator['nama'];
                        header('Location: /gantiALS/ALS/index.php?controller=operator&action=dashboard');
                        exit;
                    } else {
                        $_SESSION['error'] = "Email atau password salah.";
                    }
                } catch (Exception $e) {
                    $_SESSION['error'] = "Terjadi kesalahan sistem.";
                }
            }
        }

        require_once __DIR__ . '/../views/operator/operatorLogin.php';
    }

    public function logout() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /gantiALS/ALS/index.php?controller=operator&action=login');
        exit;
    }
}
?>