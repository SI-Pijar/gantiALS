<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/PengaturanModel.php';
require_once __DIR__ . '/../models/LogModel.php';

class PengaturanController {

    public function index() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $database        = new Database();
        $db              = $database->connect();
        $pengaturanModel = new PengaturanModel($db);
        $pengaturan      = $pengaturanModel->getAllPengaturan();

        require_once __DIR__ . '/../views/admin/pengaturan/index.php';
    }

    public function simpan() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $database        = new Database();
        $db              = $database->connect();
        $pengaturanModel = new PengaturanModel($db);

        $fields = ['nama_aplikasi', 'tarif_dasar', 'email_notifikasi', 'maintenance_mode'];
        foreach ($fields as $field) {
            $nilai = $_POST[$field] ?? '';
            $pengaturanModel->upsert($field, $nilai);
        }

        $logModel = new LogModel($db);
        $logModel->createLog($_SESSION['admin_id'], 'Memperbarui pengaturan sistem', 'berhasil');

        $pengaturan = $pengaturanModel->getAllPengaturan();
        $success    = 'Pengaturan berhasil disimpan.';

        require_once __DIR__ . '/../views/admin/pengaturan/index.php';
    }
}
