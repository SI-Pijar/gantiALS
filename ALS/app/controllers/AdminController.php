<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/TransaksiModel.php';
require_once __DIR__ . '/../models/LogModel.php';
require_once __DIR__ . '/../models/PenumpangModel.php';
require_once __DIR__ . '/../models/PengaturanModel.php';

class AdminController {
    protected $db;
    protected $adminModel;
    protected $jadwalModel;
    protected $transaksiModel;
    protected $logModel;
    protected $penumpangModel;
    protected $pengaturanModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['admin_id'])) {
            header('Location: /gantiALS/index.php?controller=auth&action=login');
            exit;
        }

        $database = new Database();
        $this->db = $database->connect();
        $this->adminModel = new AdminModel($this->db);
        $this->jadwalModel = new JadwalModel($this->db);
        $this->transaksiModel = new TransaksiModel($this->db);
        $this->logModel = new LogModel($this->db);
        $this->penumpangModel = new PenumpangModel($this->db);
        $this->pengaturanModel = new PengaturanModel($this->db);
    }

    
    public function dashboard() {
        $totalPendapatan = $this->transaksiModel->getTotalPendapatanHariIni();
        $tiketTerjual = $this->transaksiModel->getTiketTerjualHariIni();
        $totalJadwal = count($this->jadwalModel->getAllJadwal());
        $gangguanSistem = count($this->logModel->getLogByLevel('error'));
        $aktivitasTerbaru = $this->logModel->getAllLog();

        require_once __DIR__ . '/../views/admin/adminDashboard.php';
    }

    
    public function jadwal() {
        $action = $_GET['action'] ?? 'index';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($action === 'add') {
            $this->jadwalAdd();
        } elseif ($action === 'edit' && $id) {
            $this->jadwalEdit($id);
        } elseif ($action === 'delete' && $id) {
            $this->jadwalDelete($id);
        } else {
            $this->jadwalIndex();
        }
    }

    private function jadwalIndex() {
        $jadwals = $this->jadwalModel->getAllJadwal();
        $viewMode = 'list';
        require_once __DIR__ . '/../views/admin/adminJadwal.php';
    }

    private function jadwalAdd() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $asal = trim($_POST['asal'] ?? '');
            $tujuan = trim($_POST['tujuan'] ?? '');
            $tanggal = $_POST['tanggal'] ?? '';
            $jam_berangkat = $_POST['jam_berangkat'] ?? '';
            $jam_tiba = $_POST['jam_tiba'] ?? '';
            $harga = (int)($_POST['harga'] ?? 0);
            $kursi = (int)($_POST['kursi_tersedia'] ?? 0);
            $status = $_POST['status'] ?? 'aktif';

            if (empty($asal) || empty($tujuan) || empty($tanggal)) {
                $error = 'Asal, tujuan, dan tanggal wajib diisi.';
                $viewMode = 'form';
                $jadwal = null;
            } else {
                if ($this->jadwalModel->createJadwal($asal, $tujuan, $tanggal, $jam_berangkat, $jam_tiba, $harga, $kursi, $status)) {
                    $this->logModel->createLog($_SESSION['admin_id'], "Menambahkan jadwal baru: $asal - $tujuan", 'berhasil');
                    header('Location: /gantiALS/admin/jadwal');
                    exit;
                } else {
                    $error = 'Gagal menyimpan jadwal.';
                    $viewMode = 'form';
                    $jadwal = null;
                }
            }
        } else {
            $viewMode = 'form';
            $jadwal = null;
            $error = '';
        }
        require_once __DIR__ . '/../views/admin/adminJadwal.php';
    }

    private function jadwalEdit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $asal = trim($_POST['asal'] ?? '');
            $tujuan = trim($_POST['tujuan'] ?? '');
            $tanggal = $_POST['tanggal'] ?? '';
            $jam_berangkat = $_POST['jam_berangkat'] ?? '';
            $jam_tiba = $_POST['jam_tiba'] ?? '';
            $harga = (int)($_POST['harga'] ?? 0);
            $kursi = (int)($_POST['kursi_tersedia'] ?? 0);
            $status = $_POST['status'] ?? 'aktif';

            if (empty($asal) || empty($tujuan) || empty($tanggal)) {
                $error = 'Asal, tujuan, dan tanggal wajib diisi.';
                $viewMode = 'form';
                $jadwal = $this->jadwalModel->getJadwalById($id);
            } else {
                if ($this->jadwalModel->updateJadwal($id, $asal, $tujuan, $tanggal, $jam_berangkat, $jam_tiba, $harga, $kursi, $status)) {
                    $this->logModel->createLog($_SESSION['admin_id'], "Mengubah jadwal ID $id", 'berhasil');
                    header('Location: /gantiALS/admin/jadwal');
                    exit;
                } else {
                    $error = 'Gagal mengubah jadwal.';
                    $viewMode = 'form';
                    $jadwal = $this->jadwalModel->getJadwalById($id);
                }
            }
        } else {
            $jadwal = $this->jadwalModel->getJadwalById($id);
            if (!$jadwal) {
                header('Location: /gantiALS/admin/jadwal');
                exit;
            }
            $viewMode = 'form';
            $error = '';
        }
        require_once __DIR__ . '/../views/admin/adminJadwal.php';
    }

    private function jadwalDelete($id) {
        if ($this->jadwalModel->deleteJadwal($id)) {
            $this->logModel->createLog($_SESSION['admin_id'], "Menghapus jadwal ID $id", 'berhasil');
        }
        header('Location: /gantiALS/admin/jadwal');
        exit;
    }

    
    public function transaksi() {
        $action = $_GET['action'] ?? 'index';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($action === 'detail' && $id) {
            $this->transaksiDetail($id);
        } else {
            $this->transaksiIndex();
        }
    }

    private function transaksiIndex() {
        $filter_status = $_GET['filter_status'] ?? '';
        $filter_date = $_GET['filter_date'] ?? '';

        if ($filter_status || $filter_date) {
            $transaksis = $this->transaksiModel->getTransaksiFiltered($filter_status, $filter_date);
        } else {
            $transaksis = $this->transaksiModel->getAllTransaksi();
        }

        $viewMode = 'list';
        require_once __DIR__ . '/../views/admin/adminTransaksi.php';
    }

    private function transaksiDetail($id) {
        $transaksi = $this->transaksiModel->getTransaksiById($id);
        if (!$transaksi) {
            header('Location: /gantiALS/admin/transaksi');
            exit;
        }
        $viewMode = 'detail';
        require_once __DIR__ . '/../views/admin/adminTransaksi.php';
    }

    
    public function log() {
        $filter_level = $_GET['filter_level'] ?? '';
        $filter_date = $_GET['filter_date'] ?? '';

        if ($filter_level || $filter_date) {
            $logs = $this->logModel->getLogFiltered($filter_level, $filter_date);
        } else {
            $logs = $this->logModel->getAllLog();
        }

        require_once __DIR__ . '/../views/admin/adminLog.php';
    }

    
    public function pengaturan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama_aplikasi = trim($_POST['nama_aplikasi'] ?? '');
            $email_support = trim($_POST['email_support'] ?? '');
            $nomor_telepon = trim($_POST['nomor_telepon'] ?? '');
            $alamat = trim($_POST['alamat'] ?? '');

            if ($this->pengaturanModel->updateSettings($nama_aplikasi, $email_support, $nomor_telepon, $alamat)) {
                $this->logModel->createLog($_SESSION['admin_id'], 'Mengubah pengaturan sistem', 'berhasil');
                $_SESSION['success'] = 'Pengaturan berhasil disimpan.';
            } else {
                $_SESSION['error'] = 'Gagal menyimpan pengaturan.';
            }
            header('Location: /gantiALS/admin/pengaturan');
            exit;
        }

        $settings = $this->pengaturanModel->getSettings();
        require_once __DIR__ . '/../views/admin/adminPengaturan.php';
    }

    
    public function penumpang() {
        $action = $_GET['action'] ?? 'index';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($action === 'detail' && $id) {
            $this->penumpangDetail($id);
        } elseif ($action === 'suspend' && $id) {
            $this->penumpangSuspend($id);
        } else {
            $this->penumpangIndex();
        }
    }

    private function penumpangIndex() {
        $penumpangs = $this->penumpangModel->getAllPenumpang();
        $viewMode = 'list';
        require_once __DIR__ . '/../views/admin/adminPenumpang.php';
    }

    private function penumpangDetail($id) {
        $penumpang = $this->penumpangModel->getPenumpangById($id);
        if (!$penumpang) {
            header('Location: /gantiALS/admin/penumpang');
            exit;
        }
        $viewMode = 'detail';
        require_once __DIR__ . '/../views/admin/adminPenumpang.php';
    }

    private function penumpangSuspend($id) {
        if ($this->penumpangModel->updateStatus($id, 'suspended')) {
            $this->logModel->createLog($_SESSION['admin_id'], "Suspend penumpang ID $id", 'berhasil');
        }
        header('Location: /gantiALS/admin/penumpang');
        exit;
    }
}
?>