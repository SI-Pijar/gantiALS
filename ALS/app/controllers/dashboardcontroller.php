<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/TransaksiModel.php';
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/LogModel.php';

class DashboardController {

    public function index() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $database       = new Database();
        $db             = $database->connect();
        $transaksiModel = new TransaksiModel($db);
        $adminModel     = new AdminModel($db);
        $logModel       = new LogModel($db);

        $totalPendapatan    = $transaksiModel->getTotalPendapatanHariIni();
        $tiketTerjual       = $transaksiModel->getTiketTerjualHariIni();
        $totalPenumpang      = $adminModel->countAdmins();
        $gangguanSistem     = $logModel->countErrorHariIni();
        $aktivitasTerbaru   = $logModel->getAktivitasTerbaru(5);

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
}
