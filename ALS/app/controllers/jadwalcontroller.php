<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/LogModel.php';

class JadwalController {

    public function index() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $database     = new Database();
        $db           = $database->connect();
        $jadwalModel  = new JadwalModel($db);
        $jadwals      = $jadwalModel->getAllJadwal();

        require_once __DIR__ . '/../views/admin/jadwal/index.php';
    }

    public function tambahForm() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $jadwal = null;
        require_once __DIR__ . '/../views/admin/jadwal/form.php';
    }

    public function tambah() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

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

        $database    = new Database();
        $db          = $database->connect();
        $jadwalModel = new JadwalModel($db);
        $berhasil    = $jadwalModel->createJadwal($asal, $tujuan, $tanggal, $jam_berangkat, $jam_tiba, $harga, $kursi, $status);

        if ($berhasil) {
            $logModel = new LogModel($db);
            $logModel->createLog($_SESSION['admin_id'], "Menambahkan jadwal baru: $asal - $tujuan", 'berhasil');
            $success = 'Jadwal berhasil ditambahkan.';
        } else {
            $error = 'Gagal menyimpan jadwal.';
        }

        $jadwals = $jadwalModel->getAllJadwal();
        require_once __DIR__ . '/../views/admin/jadwal/index.php';
    }

    public function editForm() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id          = (int)($_GET['id'] ?? 0);
        $database    = new Database();
        $db          = $database->connect();
        $jadwalModel = new JadwalModel($db);
        $jadwal      = $jadwalModel->getJadwalById($id);

        if (!$jadwal) {
            header('Location: index.php?page=jadwal');
            exit;
        }

        require_once __DIR__ . '/../views/admin/jadwal/form.php';
    }

    public function edit() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id            = (int)($_POST['id']            ?? 0);
        $asal          = trim($_POST['asal']           ?? '');
        $tujuan        = trim($_POST['tujuan']         ?? '');
        $tanggal       = $_POST['tanggal']        ?? '';
        $jam_berangkat = $_POST['jam_berangkat']  ?? '';
        $jam_tiba      = $_POST['jam_tiba']       ?? '';
        $harga         = (int)($_POST['harga']    ?? 0);
        $kursi         = (int)($_POST['kursi_tersedia'] ?? 0);
        $status        = $_POST['status']         ?? 'aktif';

        $database    = new Database();
        $db          = $database->connect();
        $jadwalModel = new JadwalModel($db);
        $berhasil    = $jadwalModel->updateJadwal($id, $asal, $tujuan, $tanggal, $jam_berangkat, $jam_tiba, $harga, $kursi, $status);

        if ($berhasil) {
            $logModel = new LogModel($db);
            $logModel->createLog($_SESSION['admin_id'], "Mengubah jadwal ID#$id: $asal - $tujuan", 'berhasil');
            $success = 'Jadwal berhasil diperbarui.';
        } else {
            $error = 'Gagal memperbarui jadwal.';
        }

        $jadwals = $jadwalModel->getAllJadwal();
        require_once __DIR__ . '/../views/admin/jadwal/index.php';
    }

    public function hapus() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id          = (int)($_GET['id'] ?? 0);
        $database    = new Database();
        $db          = $database->connect();
        $jadwalModel = new JadwalModel($db);
        $jadwal      = $jadwalModel->getJadwalById($id);

        if ($jadwal && $jadwalModel->deleteJadwal($id)) {
            $logModel = new LogModel($db);
            $logModel->createLog($_SESSION['admin_id'], "Menghapus jadwal: {$jadwal['asal']} - {$jadwal['tujuan']}", 'berhasil');
            $success = 'Jadwal berhasil dihapus.';
        } else {
            $error = 'Gagal menghapus jadwal.';
        }

        $jadwals = $jadwalModel->getAllJadwal();
        require_once __DIR__ . '/../views/admin/jadwal/index.php';
    }
}
