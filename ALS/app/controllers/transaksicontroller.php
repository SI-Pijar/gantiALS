<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/TransaksiModel.php';

class TransaksiController {

    public function index() {

        $database = new Database();
        $db = $database->connect();
        $transaksiModel = new TransaksiModel($db);
        $transaksis = $transaksiModel->findAll();

        require_once __DIR__ . '/../views/admin/laporanTransaksi.php';
    }

    public function detail($id) {

        $database = new Database();
        $db = $database->connect();
        $transaksiModel = new TransaksiModel($db);
        $transaksi = $transaksiModel->findById($id);

        require_once __DIR__ . '/../views/admin/detailTransaksi.php';
    }

    public function filter() {

        $database = new Database();
        $db = $database->connect();

        $transaksiModel = new TransaksiModel($db);
        $dari = $_POST['dari'];
        $sampai = $_POST['sampai'];
        $status = $_POST['status'];

        $transaksis = $transaksiModel->findAll();

        require_once __DIR__ . '/../views/admin/laporanTransaksi.php';
    }

    public function ekspor() {

        $database = new Database();
        $db = $database->connect();
        $transaksiModel = new TransaksiModel($db);
        $transaksis = $transaksiModel->findAll();

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename=laporan_transaksi.csv');

        $output = fopen('php://output', 'w');

        fputcsv($output, [
            'Invoice',
            'Pengguna',
            'Rute',
            'Total',
            'Status'
        ]);

        foreach ($transaksis as $t) {

            fputcsv($output, [
                $t['nomor_invoice'],
                $t['nama_pengguna'],
                $t['asal'] . ' - ' . $t['tujuan'],
                $t['total_harga'],
                $t['status']
            ]);
        }

        fclose($output);
    }
}