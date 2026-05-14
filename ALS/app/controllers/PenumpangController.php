<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/PenumpangModel.php';
require_once __DIR__ . '/../models/JadwalModel.php';
require_once __DIR__ . '/../models/PemesananModel.php';

class PenumpangController {
    private $db;
    private $penumpangModel;
    private $jadwalModel;
    private $pemesananModel;

    public function __construct() {
        $database = new Database();
        $this->db = $database->connect();
        $this->penumpangModel = new PenumpangModel($this->db);
        $this->jadwalModel = new JadwalModel($this->db);
        $this->pemesananModel = new PemesananModel($this->db);
    }

    public function index() {
        $asals = $this->jadwalModel->getDistinctAsal();
        $tujuans = $this->jadwalModel->getDistinctTujuan();
        require_once __DIR__ . '/../views/penumpang/penumpangHome.php';
    }

    public function jadwal() {
        $asal = $_GET['asal'] ?? '';
        $tujuan = $_GET['tujuan'] ?? '';
        $tanggal = $_GET['tanggal'] ?? '';

        $jadwals = $this->jadwalModel->searchJadwal($asal, $tujuan, $tanggal);

        require_once __DIR__ . '/../views/penumpang/penumpangJadwal.php';
    }

    public function pemesanan() {
        $id = (int)($_GET['id'] ?? 0);
        $jadwal = $this->jadwalModel->getJadwalById($id);

        if (!$jadwal) {
            header('Location: index.php');
            exit;
        }

        $kursiTerisi = $this->pemesananModel->getKursiTerisi($id);

        require_once __DIR__ . '/../views/penumpang/penumpangPemesanan.php';
    }

    public function prosesPemesanan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id_jadwal = (int)$_POST['id_jadwal'];
            $nama = trim($_POST['nama_lengkap']);
            $email = trim($_POST['email']);
            $telepon = trim($_POST['nomor_telepon']);
            $kursi_dipesan = trim($_POST['kursi_dipesan']);

            if (empty($kursi_dipesan)) {
                echo "Anda belum memilih kursi.";
                exit;
            }

            $kursi_array = explode(',', $kursi_dipesan);
            $jumlah = count($kursi_array);

            $jadwal = $this->jadwalModel->getJadwalById($id_jadwal);
            $total_harga = $jadwal['harga'] * $jumlah;

            $id_pemesanan = $this->pemesananModel->buatPemesanan($id_jadwal, $nama, $email, $telepon, $jumlah, $total_harga, $kursi_dipesan);

            if ($id_pemesanan) {
                $this->jadwalModel->updateKursi($id_jadwal, $jumlah);
                
                header("Location: index.php?page=pembayaran&id=$id_pemesanan");
                exit;
            } else {
                echo "Gagal melakukan pemesanan.";
            }
        }
    }

    public function pembayaran() {
        $id = (int)($_GET['id'] ?? 0);
        $pesanan = $this->pemesananModel->getPemesananById($id);

        if (!$pesanan || $pesanan['status_pembayaran'] !== 'pending') {
            header('Location: index.php');
            exit;
        }

        require_once __DIR__ . '/../views/penumpang/penumpangPembayaran.php';
    }

    public function prosesPembayaran() {
        $id = (int)($_POST['id_pemesanan'] ?? 0);
        $metode = $_POST['metode_pembayaran'] ?? '';

        if ($id && !empty($metode)) {
            $this->pemesananModel->updateStatus($id, 'berhasil');
            header("Location: index.php?page=tiket&id=$id");
            exit;
        }
        header("Location: index.php");
        exit;
    }

    public function tiket() {
        $id = (int)($_GET['id'] ?? 0);
        $tiket = $this->pemesananModel->getPemesananById($id);

        if (!$tiket) {
            header('Location: index.php');
            exit;
        }
        require_once __DIR__ . '/../views/penumpang/penumpangTiket.php';
    }
}