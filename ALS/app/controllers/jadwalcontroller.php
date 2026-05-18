<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/LogModel.php';

class JadwalController {
    private $db;
    private $jadwalModel;
    private $logModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $database     = new Database();
        $this->db     = $database->connect();
        $this->jadwalModel = new JadwalModel($this->db);
        $this->logModel    = new LogModel($this->db);
    }

    public function index() {
        $jadwals = $this->jadwalModel->getAllJadwal();

        require_once __DIR__ . '/../views/admin/jadwal/index.php';
    }

    public function tambahForm() {
        $jadwal = null;
        require_once __DIR__ . '/../views/admin/jadwal/form.php';
    }

    public function tambah() {
        $asal          = trim($_POST['asal']          ?? '');
        $tujuan        = trim($_POST['tujuan']        ?? '');
        $tanggal       = $_POST['tanggal']       ?? '';
        $jam_berangkat = $_POST['jam_berangkat'] ?? '';
        $jam_tiba      = $_POST['jam_tiba']      ?? '';
        $harga         = (int)($_POST['harga']   ?? 0);
        $kursi         = (int)($_POST['kursi_tersedia'] ?? 0);
        $status        = $_POST['status']        ?? 'aktif';

        if (empty($asal) || empty($tujuan) || empty($tanggal)) {
            $error  = 'Asal, tujuan, dan tanggal wajib diisi.';
            $jadwal = null;
            require_once __DIR__ . '/../views/admin/jadwal/form.php';
            return;
        }

        $berhasil = $this->jadwalModel->createJadwal($asal, $tujuan, $tanggal, $jam_berangkat, $jam_tiba, $harga, $kursi, $status);

        if ($berhasil) {
            $this->logModel->createLog($_SESSION['admin_id'], "Menambahkan jadwal baru: $asal - $tujuan", 'berhasil');
            $success = 'Jadwal berhasil ditambahkan.';
        } else {
            $error = 'Gagal menyimpan jadwal.';
        }

        $jadwals = $this->jadwalModel->getAllJadwal();
        require_once __DIR__ . '/../views/admin/jadwal/index.php';
    }

    public function editForm() {
        $id          = (int)($_GET['id'] ?? 0);
        $jadwal      = $this->jadwalModel->getJadwalById($id);

        if (!$jadwal) {
            header('Location: index.php?page=jadwal');
            exit;
        }

        require_once __DIR__ . '/../views/admin/jadwal/form.php';
    }

    public function edit() {
        $id            = (int)($_POST['id']            ?? 0);
        $asal          = trim($_POST['asal']           ?? '');
        $tujuan        = trim($_POST['tujuan']         ?? '');
        $tanggal       = $_POST['tanggal']        ?? '';
        $jam_berangkat = $_POST['jam_berangkat']  ?? '';
        $jam_tiba      = $_POST['jam_tiba']       ?? '';
        $harga         = (int)($_POST['harga']    ?? 0);
        $kursi         = (int)($_POST['kursi_tersedia'] ?? 0);
        $status        = $_POST['status']         ?? 'aktif';

        $berhasil = $this->jadwalModel->updateJadwal($id, $asal, $tujuan, $tanggal, $jam_berangkat, $jam_tiba, $harga, $kursi, $status);

        if ($berhasil) {
            $this->logModel->createLog($_SESSION['admin_id'], "Mengubah jadwal ID#$id: $asal - $tujuan", 'berhasil');
            $success = 'Jadwal berhasil diperbarui.';
        } else {
            $error = 'Gagal memperbarui jadwal.';
        }

        $jadwals = $this->jadwalModel->getAllJadwal();
        require_once __DIR__ . '/../views/admin/jadwal/index.php';
    }

    public function hapus() {
        $id          = (int)($_GET['id'] ?? 0);
        $jadwal      = $this->jadwalModel->getJadwalById($id);

        if ($jadwal && $this->jadwalModel->deleteJadwal($id)) {
            $this->logModel->createLog($_SESSION['admin_id'], "Menghapus jadwal: {$jadwal['asal']} - {$jadwal['tujuan']}", 'berhasil');
            $success = 'Jadwal berhasil dihapus.';
        } else {
            $error = 'Gagal menghapus jadwal.';
        }

        $jadwals = $this->jadwalModel->getAllJadwal();
        require_once __DIR__ . '/../views/admin/jadwal/index.php';
    }
}
