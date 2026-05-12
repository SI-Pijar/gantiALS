<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/TransaksiModel.php';
require_once __DIR__ . '/../models/AdminModel.php';

class DashboardController {

    public function index() {

        $database = new Database();
        $db = $database->connect();

        $transaksiModel = new TransaksiModel($db);
        $adminModel = new AdminModel($db);

        $stats = [
            'total_transaksi_hari_ini' => $transaksiModel->getTotalHariIni(),
            'tiket_terjual_hari_ini' => $transaksiModel->getTiketTerjualHariIni(),
            'total_pengguna' => $adminModel->countPengguna()
        ];

        require_once __DIR__ . '/../views/admin/dashboard.php';
    }
}