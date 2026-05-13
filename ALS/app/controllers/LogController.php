<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/LogModel.php';

class LogController {

    public function index() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $database = new Database();
        $db       = $database->connect();
        $logModel = new LogModel($db);
        $logs     = $logModel->getAllLog();

        require_once __DIR__ . '/../views/admin/log/index.php';
    }

    public function hapusSemua() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $database = new Database();
        $db       = $database->connect();
        $logModel = new LogModel($db);
        $logModel->deleteAllLog();

        // Catat ulang log penghapusan setelah dihapus
        $logModel->createLog($_SESSION['admin_id'], 'Menghapus semua log sistem', 'berhasil');

        $logs    = $logModel->getAllLog();
        $success = 'Semua log berhasil dihapus.';

        require_once __DIR__ . '/../views/admin/log/index.php';
    }
}
