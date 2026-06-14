<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/PenumpangModel.php';
require_once __DIR__ . '/../models/jadwalmodel.php';
require_once __DIR__ . '/../models/PemesananModel.php';

class PenumpangController {
    private $penumpangModel;
    private $jadwalModel;
    private $pemesananModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $db = (new Database())->connect();
        $this->penumpangModel = new PenumpangModel($db);
        $this->jadwalModel = new JadwalModel($db);
        $this->pemesananModel = new PemesananModel($db);
    }

    private function requireLogin() {
        if (!isset($_SESSION['penumpang_id'])) {
            header('Location: ' . BASEURL . '/index.php?controller=auth&action=login');
            exit;
        }
    }

    public function index() {
        $asals = array_map(fn($r) => ['asal' => $r], RUTE_ALS);
        $tujuans = array_map(fn($r) => ['tujuan' => $r], RUTE_ALS);
        require_once __DIR__ . '/../views/penumpang/penumpangHome.php';
    }

    public function jadwal() {
        $asal    = trim($_GET['asal']    ?? '');
        $tujuan  = trim($_GET['tujuan']  ?? '');
        $tanggal = trim($_GET['tanggal'] ?? '');

        $semua_kelas = ['Super Executive', 'Executive Class', 'Patas AC', 'Ekonomi AC', 'Ekonomi Non-AC'];
        $semua_waktu = ['pagi', 'siang', 'malam'];

        if (isset($_GET['filter_aktif'])) {
            $filter_kelas = isset($_GET['kelas'])
                ? array_values(array_intersect((array)$_GET['kelas'], $semua_kelas))
                : [];
            $filter_waktu = isset($_GET['waktu'])
                ? array_values(array_intersect((array)$_GET['waktu'], $semua_waktu))
                : [];
        } else {
            $kelas_awal = trim($_GET['kelas'] ?? '');
            $filter_kelas = ($kelas_awal && in_array($kelas_awal, $semua_kelas))
                ? [$kelas_awal]
                : $semua_kelas;
            $filter_waktu = $semua_waktu;
        }

        $jadwals = $this->jadwalModel->searchJadwal($asal, $tujuan, $tanggal, $filter_kelas, $filter_waktu);
        require_once __DIR__ . '/../views/penumpang/penumpangJadwal.php';
    }

    public function pemesanan() {
        $id = (int)($_GET['id'] ?? 0);
        $jadwal = $this->jadwalModel->getJadwalById($id);

        if (!$jadwal) {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        $kursiTerisi = $this->pemesananModel->getKursiTerisi($id);
        $penumpangLogin = isset($_SESSION['penumpang_id'])
            ? $this->penumpangModel->getPenumpangById($_SESSION['penumpang_id'])
            : null;

        require_once __DIR__ . '/../views/penumpang/penumpangPemesanan.php';
    }

    public function prosesPemesanan() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        $id_jadwal = (int)($_POST['id_jadwal'] ?? 0);
        $nama = trim($_POST['nama_lengkap'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $telepon = trim($_POST['nomor_telepon'] ?? '');
        $kursi_dipesan = trim($_POST['kursi_dipesan'] ?? '');

        if (empty($kursi_dipesan)) {
            $_SESSION['error'] = 'Anda belum memilih kursi.';
            header('Location: ' . BASEURL . '/index.php?page=pemesanan&id=' . $id_jadwal);
            exit;
        }

        if (empty($nama) || empty($email) || empty($telepon)) {
            $_SESSION['error'] = 'Semua field harus diisi.';
            header('Location: ' . BASEURL . '/index.php?page=pemesanan&id=' . $id_jadwal);
            exit;
        }

        $jadwal = $this->jadwalModel->getJadwalById($id_jadwal);
        if (!$jadwal) {
            $_SESSION['error'] = 'Jadwal tidak ditemukan.';
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        $kursi_array = array_filter(array_map('trim', explode(',', $kursi_dipesan)));
        $jumlah = count($kursi_array);

        if ($jumlah > $jadwal['kursi_tersedia']) {
            $_SESSION['error'] = 'Jumlah kursi yang dipesan melebihi sisa ketersediaan (' . $jadwal['kursi_tersedia'] . ' kursi).';
            header('Location: ' . BASEURL . '/index.php?page=pemesanan&id=' . $id_jadwal);
            exit;
        }

        $kursiTerisi = $this->pemesananModel->getKursiTerisi($id_jadwal);
        foreach ($kursi_array as $k) {
            if (in_array($k, $kursiTerisi)) {
                $_SESSION['error'] = 'Maaf, kursi ' . $k . ' sudah dipesan oleh orang lain.';
                header('Location: ' . BASEURL . '/index.php?page=pemesanan&id=' . $id_jadwal);
                exit;
            }
        }

        $total_harga = $jadwal['harga'] * $jumlah;
        $id_pemesanan = $this->pemesananModel->buatPemesanan(
            $id_jadwal, $nama, $email, $telepon, $jumlah, $total_harga, implode(',', $kursi_array)
        );

        if ($id_pemesanan) {
            $this->jadwalModel->updateKursi($id_jadwal, $jumlah);
            $_SESSION['success'] = 'Pemesanan berhasil dibuat.';
            header('Location: ' . BASEURL . '/index.php?page=pembayaran&id=' . $id_pemesanan);
            exit;
        }

        $_SESSION['error'] = 'Gagal melakukan pemesanan.';
        header('Location: ' . BASEURL . '/index.php?page=pemesanan&id=' . $id_jadwal);
        exit;
    }

    public function pembayaran() {
        $id = (int)($_GET['id'] ?? 0);
        $pesanan = $this->pemesananModel->getPemesananById($id);

        if (!$pesanan || $pesanan['status_pembayaran'] !== 'pending') {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        if (isset($_SESSION['penumpang_email']) && $pesanan['email'] !== $_SESSION['penumpang_email']) {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        require_once __DIR__ . '/../views/penumpang/penumpangPembayaran.php';
    }

    public function prosesPembayaran() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        $id = (int)(trim($_POST['id_pemesanan'] ?? 0));
        $metode = trim($_POST['metode_pembayaran'] ?? '');

        if (!$id || empty($metode)) {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        $pesanan = $this->pemesananModel->getPemesananById($id);

        if (!$pesanan || $pesanan['status_pembayaran'] !== 'pending') {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        if (isset($_SESSION['penumpang_email']) && $pesanan['email'] !== $_SESSION['penumpang_email']) {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        $this->pemesananModel->updateStatusPembayaran($id, 'Lunas', $metode);
        $_SESSION['success'] = 'Pembayaran berhasil.';
        header('Location: ' . BASEURL . '/index.php?page=tiket&id=' . $id);
        exit;
    }

    public function tiket() {
        $id = (int)($_GET['id'] ?? 0);
        $tiket = $this->pemesananModel->getPemesananById($id);

        if (!$tiket) {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        if (isset($_SESSION['penumpang_email']) && $tiket['email'] !== $_SESSION['penumpang_email']) {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        require_once __DIR__ . '/../views/penumpang/penumpangTiket.php';
    }

    public function riwayat() {
        $this->requireLogin();

        $email = $_SESSION['penumpang_email'] ?? '';
        $pesanans = $this->pemesananModel->getPemesananByEmail($email);
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        require_once __DIR__ . '/../views/penumpang/penumpangRiwayat.php';
    }

    public function profil() {
        $this->requireLogin();

        $penumpang = $this->penumpangModel->getPenumpangById($_SESSION['penumpang_id']);
        if (!$penumpang) {
            header('Location: ' . BASEURL . '/index.php');
            exit;
        }

        $success_profil = $_SESSION['success_profil'] ?? null;
        unset($_SESSION['success_profil']);
        $error_profil = $_SESSION['error_profil'] ?? null;
        unset($_SESSION['error_profil']);
        $success_password = $_SESSION['success_password'] ?? null;
        unset($_SESSION['success_password']);
        $error_password = $_SESSION['error_password'] ?? null;
        unset($_SESSION['error_password']);
        require_once __DIR__ . '/../views/penumpang/penumpangProfil.php';
    }

    public function prosesUbahProfil() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/index.php?page=profil');
            exit;
        }

        $nama_baru = trim($_POST['nama_lengkap'] ?? '');

        if (empty($nama_baru)) {
            $_SESSION['error_profil'] = 'Nama tidak boleh kosong.';
            header('Location: ' . BASEURL . '/index.php?page=profil');
            exit;
        }

        if ($this->penumpangModel->updateProfil($_SESSION['penumpang_id'], $nama_baru)) {
            $_SESSION['penumpang_name'] = $nama_baru;
            $_SESSION['success_profil'] = 'Nama berhasil diperbarui.';
        } else {
            $_SESSION['error_profil'] = 'Gagal memperbarui nama.';
        }

        header('Location: ' . BASEURL . '/index.php?page=profil');
        exit;
    }

    public function prosesGantiPassword() {
        $this->requireLogin();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: ' . BASEURL . '/index.php?page=profil');
            exit;
        }

        $password_lama = $_POST['password_lama'] ?? '';
        $password_baru = $_POST['password_baru'] ?? '';
        $konfirmasi = $_POST['konfirmasi_password'] ?? '';

        $hash_lama = $this->penumpangModel->getPasswordById($_SESSION['penumpang_id']);

        if (!password_verify($password_lama, $hash_lama)) {
            $_SESSION['error_password'] = 'Password lama tidak sesuai.';
            header('Location: ' . BASEURL . '/index.php?page=profil');
            exit;
        }

        if (strlen($password_baru) < 8) {
            $_SESSION['error_password'] = 'Password baru minimal 8 karakter.';
            header('Location: ' . BASEURL . '/index.php?page=profil');
            exit;
        }

        if ($password_baru !== $konfirmasi) {
            $_SESSION['error_password'] = 'Konfirmasi password tidak cocok.';
            header('Location: ' . BASEURL . '/index.php?page=profil');
            exit;
        }

        if ($this->penumpangModel->updatePassword($_SESSION['penumpang_id'], $password_baru)) {
            $_SESSION['success_password'] = 'Password berhasil diubah.';
        } else {
            $_SESSION['error_password'] = 'Gagal mengubah password.';
        }

        header('Location: ' . BASEURL . '/index.php?page=profil');
        exit;
    }
}
