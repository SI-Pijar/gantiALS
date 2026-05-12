<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/JadwalModel.php';

class JadwalController {

    public function index() {

        $database = new Database();
        $db = $database->connect();

        $jadwalModel = new JadwalModel($db);
        $jadwals = $jadwalModel->findAktif();

        require_once __DIR__ . '/../views/admin/kelolaJadwal.php';
    }

    public function tambah() {

        $database = new Database();
        $db = $database->connect();

        $jadwalModel = new JadwalModel($db);

        $data = [
            'asal' => $_POST['asal'],
            'tujuan' => $_POST['tujuan'],
            'tanggal' => $_POST['tanggal'],
            'jam_berangkat' => $_POST['jam_berangkat'],
            'jam_tiba' => $_POST['jam_tiba'],
            'harga' => $_POST['harga'],
            'kursi_tersedia' => $_POST['kursi_tersedia']
        ];

        $jadwalModel->insert($data);

        header("Location: jadwal.php");
        exit;
    }

    public function edit($id) {

        $database = new Database();
        $db = $database->connect();

        $jadwalModel = new JadwalModel($db);

        $data = [
            'asal' => $_POST['asal'],
            'tujuan' => $_POST['tujuan'],
            'tanggal' => $_POST['tanggal'],
            'jam_berangkat' => $_POST['jam_berangkat'],
            'jam_tiba' => $_POST['jam_tiba'],
            'harga' => $_POST['harga'],
            'kursi_tersedia' => $_POST['kursi_tersedia']
        ];

        $jadwalModel->update($id, $data);

        header("Location: jadwal.php");
        exit;
    }

    public function hapus($id) {

        $database = new Database();
        $db = $database->connect();
        $jadwalModel = new JadwalModel($db);
        $jadwalModel->delete($id);

        header("Location: jadwal.php");
        exit;
    }
}