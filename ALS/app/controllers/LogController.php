<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/LogModel.php';

class LogController {
    private $db;
    private $logModel;

    public function __construct() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }
        $database = new Database();
        $this->db = $database->connect();
        $this->logModel = new LogModel($this->db);
    }

    public function index() {
        $logs = $this->logModel->getAllLog();

        require_once __DIR__ . '/../views/admin/log/index.php';
    }

    public function hapusSemua() {
        $this->logModel->deleteAllLog();

        $this->logModel->createLog($_SESSION['admin_id'], 'Menghapus semua log sistem', 'berhasil');

        $logs    = $this->logModel->getAllLog();
        $success = 'Semua log berhasil dihapus.';

        require_once __DIR__ . '/../views/admin/log/index.php';
    }
}
