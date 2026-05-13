<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/TransaksiModel.php';

class TransaksiController {

    public function index() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $database       = new Database();
        $db             = $database->connect();
        $transaksiModel = new TransaksiModel($db);
        $transaksis     = $transaksiModel->getAllTransaksi();

        $dari   = '';
        $sampai = '';
        $status = '';

        require_once __DIR__ . '/../views/admin/transaksi/index.php';
    }

    public function detail() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id             = (int)($_GET['id'] ?? 0);
        $database       = new Database();
        $db             = $database->connect();
        $transaksiModel = new TransaksiModel($db);
        $transaksi      = $transaksiModel->getTransaksiById($id);

        if (!$transaksi) {
            header('Location: index.php?page=transaksi');
            exit;
        }

        require_once __DIR__ . '/../views/admin/transaksi/detail.php';
    }

    public function filter() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $dari   = $_POST['dari']   ?? '';
        $sampai = $_POST['sampai'] ?? '';
        $status = $_POST['status'] ?? '';

        $database       = new Database();
        $db             = $database->connect();
        $transaksiModel = new TransaksiModel($db);
        $transaksis     = $transaksiModel->filterTransaksi($dari, $sampai, $status);

        require_once __DIR__ . '/../views/admin/transaksi/index.php';
    }
}
