<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/jadwalmodel.php';
require_once __DIR__ . '/../models/transaksimodel.php';
require_once __DIR__ . '/../models/LogModel.php';
require_once __DIR__ . '/../models/PenumpangModel.php';
require_once __DIR__ . '/../models/PengaturanModel.php';
require_once __DIR__ . '/../models/OperatorModel.php';

class AdminController {
    protected $adminModel;
    protected $jadwalModel;
    protected $transaksiModel;
    protected $logModel;
    protected $penumpangModel;
    protected $pengaturanModel;
    protected $operatorModel;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['admin_id'])) {
            header('Location: ' . BASEURL . '/index.php?controller=auth&action=login');
            exit;
        }
        $db = (new Database())->connect();
        $this->adminModel = new AdminModel($db);
        $this->jadwalModel = new JadwalModel($db);
        $this->transaksiModel = new TransaksiModel($db);
        $this->logModel = new LogModel($db);
        $this->penumpangModel = new PenumpangModel($db);
        $this->pengaturanModel = new PengaturanModel($db);
        $this->operatorModel = new OperatorModel($db);
    }

    public function dashboard() {
        $totalPendapatan = $this->transaksiModel->getTotalPendapatanHariIni();
        $tiketTerjual = $this->transaksiModel->getTiketTerjualHariIni();
        $totalJadwal = $this->jadwalModel->countJadwal();
        $totalPenumpang = $this->penumpangModel->countPenumpang();
        $gangguanSistem = $this->logModel->countLogByLevel('error');
        $aktivitasTerbaru = $this->logModel->getAktivitasTerbaru(5);
        require_once __DIR__ . '/../views/admin/adminDashboard.php';
    }

    public function jadwal() {
        $sub_action = $_GET['sub_action'] ?? 'index';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($sub_action === 'edit' && $id) $this->jadwalEdit($id);
        elseif ($sub_action === 'delete' && $id) $this->jadwalDelete($id);
        elseif ($sub_action === 'approve' && $id) $this->jadwalStatus($id, 'aktif');
        elseif ($sub_action === 'reject' && $id) $this->jadwalStatus($id, 'ditolak');
        else $this->jadwalIndex();
    }

    private function jadwalIndex() {
        $jadwals = $this->jadwalModel->getAllJadwal();
        $ruteList = RUTE_ALS;
        $viewMode = 'list';
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/admin/adminJadwal.php';
    }

    private function jadwalEdit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $asal = trim($_POST['asal'] ?? '');
            $tujuan = trim($_POST['tujuan'] ?? '');
            $tanggal = $_POST['tanggal'] ?? '';
            $jam_berangkat = $_POST['jam_berangkat'] ?? '';
            $harga = (int)($_POST['harga'] ?? 0);
            $kursi = (int)($_POST['kursi_tersedia'] ?? 0);
            $status = $_POST['status'] ?? 'aktif';

            if (empty($asal) || empty($tujuan) || empty($tanggal)) {
                $error = 'Asal, tujuan, dan tanggal wajib diisi.';
                $viewMode = 'form';
                $jadwal = $this->jadwalModel->getJadwalById($id);
            } elseif ($this->jadwalModel->updateJadwal($id, $asal, $tujuan, $tanggal, $jam_berangkat, $harga, $kursi, $status)) {
                $this->logModel->createLog($_SESSION['admin_id'], "Mengubah jadwal ID $id", 'berhasil');
                header('Location: ' . BASEURL . '/index.php?controller=admin&action=jadwal');
                exit;
            } else {
                $error = 'Gagal mengubah jadwal.';
                $viewMode = 'form';
                $jadwal = $this->jadwalModel->getJadwalById($id);
            }
        } else {
            $jadwal = $this->jadwalModel->getJadwalById($id);
            if (!$jadwal) {
                header('Location: ' . BASEURL . '/index.php?controller=admin&action=jadwal');
                exit;
            }
            $viewMode = 'form';
            $error = '';
        }
        $ruteList = RUTE_ALS;
        require_once __DIR__ . '/../views/admin/adminJadwal.php';
    }

    private function jadwalDelete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if ($this->jadwalModel->deleteJadwal($id)) {
                    $this->logModel->createLog($_SESSION['admin_id'], "Menghapus jadwal ID $id", 'berhasil');
                    $_SESSION['success'] = 'Jadwal berhasil dihapus.';
                }
            } catch (Exception $e) {
                $this->logModel->createLog($_SESSION['admin_id'], "Gagal menghapus jadwal ID $id", 'error');
                $_SESSION['error'] = 'Jadwal tidak bisa dihapus karena memiliki data transaksi terkait.';
            }
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=jadwal');
            exit;
        }
        $konfirmasi_pesan   = 'Yakin ingin menghapus jadwal ini?';
        $konfirmasi_action  = BASEURL . '/index.php?controller=admin&action=jadwal&sub_action=delete&id=' . $id;
        $konfirmasi_kembali = BASEURL . '/index.php?controller=admin&action=jadwal';
        $konfirmasi_css_file = 'admin';
        require_once __DIR__ . '/../views/konfirmasi.php';
    }

    private function jadwalStatus($id, $status) {
        if ($this->jadwalModel->updateStatusJadwal($id, $status)) {
            $this->logModel->createLog($_SESSION['admin_id'], "Mengubah status jadwal ID $id menjadi $status", 'berhasil');
            $_SESSION['success'] = "Status jadwal berhasil diubah menjadi $status.";
        } else {
            $_SESSION['error'] = 'Gagal mengubah status jadwal.';
        }
        header('Location: ' . BASEURL . '/index.php?controller=admin&action=jadwal');
        exit;
    }

    public function transaksi() {
        $sub_action = $_GET['sub_action'] ?? 'index';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        if ($sub_action === 'detail' && $id) $this->transaksiDetail($id);
        else $this->transaksiIndex();
    }

    private function transaksiIndex() {
        $filter_status = $_GET['filter_status'] ?? '';
        $filter_dari = $_GET['filter_dari'] ?? '';
        $filter_sampai = $_GET['filter_sampai'] ?? '';

        $transaksis = ($filter_status || $filter_dari || $filter_sampai)
            ? $this->transaksiModel->getTransaksiFiltered($filter_status, $filter_dari, $filter_sampai)
            : $this->transaksiModel->getAllTransaksi();

        $viewMode = 'list';
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        require_once __DIR__ . '/../views/admin/adminTransaksi.php';
    }

    private function transaksiDetail($id) {
        $transaksi = $this->transaksiModel->getTransaksiById($id);
        if (!$transaksi) {
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=transaksi');
            exit;
        }
        $viewMode = 'detail';
        require_once __DIR__ . '/../views/admin/adminTransaksi.php';
    }

    public function log() {
        $sub_action = $_GET['sub_action'] ?? '';

        if ($sub_action === 'hapus_semua') {
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $this->logModel->deleteAllLog();
                $this->logModel->createLog($_SESSION['admin_id'], 'Menghapus semua log sistem', 'berhasil');
                $_SESSION['success'] = 'Semua log berhasil dihapus.';
                header('Location: ' . BASEURL . '/index.php?controller=admin&action=log');
                exit;
            }
            $konfirmasi_pesan    = 'Yakin ingin menghapus semua log sistem? Tindakan ini tidak dapat dibatalkan.';
            $konfirmasi_action   = BASEURL . '/index.php?controller=admin&action=log&sub_action=hapus_semua';
            $konfirmasi_kembali  = BASEURL . '/index.php?controller=admin&action=log';
            $konfirmasi_css_file = 'admin';
            require_once __DIR__ . '/../views/konfirmasi.php';
            return;
        }

        $filter_level = $_GET['filter_level'] ?? '';
        $filter_date  = $_GET['filter_date'] ?? '';
        $logs = ($filter_level || $filter_date)
            ? $this->logModel->getLogFiltered($filter_level, $filter_date)
            : $this->logModel->getAllLog();
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        require_once __DIR__ . '/../views/admin/adminLog.php';
    }

    public function pengaturan() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email_support = trim($_POST['email_support'] ?? '');
            $nomor_telepon = trim($_POST['nomor_telepon'] ?? '');
            $alamat = trim($_POST['alamat'] ?? '');

            if ($this->pengaturanModel->updateSettings($email_support, $nomor_telepon, $alamat)) {
                $this->logModel->createLog($_SESSION['admin_id'], 'Mengubah pengaturan sistem', 'berhasil');
                $_SESSION['success'] = 'Pengaturan berhasil disimpan.';
            } else {
                $_SESSION['error'] = 'Gagal menyimpan pengaturan.';
            }
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=pengaturan');
            exit;
        }
        $settings = $this->pengaturanModel->getSettings();
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/admin/adminPengaturan.php';
    }

    public function penumpang() {
        $sub_action = $_GET['sub_action'] ?? 'index';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($sub_action === 'detail' && $id) $this->penumpangDetail($id);
        elseif ($sub_action === 'suspend' && $id) $this->penumpangSetStatus($id, 'suspended');
        elseif ($sub_action === 'activate' && $id) $this->penumpangSetStatus($id, 'aktif');
        else $this->penumpangIndex();
    }

    private function penumpangIndex() {
        $penumpangs = $this->penumpangModel->getAllPenumpang();
        $viewMode = 'list';
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/admin/adminPenumpang.php';
    }

    private function penumpangDetail($id) {
        $penumpang = $this->penumpangModel->getPenumpangById($id);
        if (!$penumpang) {
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=penumpang');
            exit;
        }
        $viewMode = 'detail';
        require_once __DIR__ . '/../views/admin/adminPenumpang.php';
    }

    private function penumpangSetStatus($id, $status) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->penumpangModel->updateStatus($id, $status)) {
                $label = $status === 'suspended' ? 'Nonaktifkan' : 'Aktifkan';
                $this->logModel->createLog($_SESSION['admin_id'], "$label penumpang ID $id", 'berhasil');
                $_SESSION['success'] = "Akun penumpang berhasil di-$status.";
            } else {
                $_SESSION['error'] = 'Gagal mengubah status penumpang.';
            }
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=penumpang');
            exit;
        }
        $sub    = $status === 'suspended' ? 'suspend' : 'activate';
        $label  = $status === 'suspended' ? 'nonaktifkan' : 'aktifkan kembali';
        $konfirmasi_pesan   = "Yakin ingin $label akun penumpang ini?";
        $konfirmasi_action  = BASEURL . '/index.php?controller=admin&action=penumpang&sub_action=' . $sub . '&id=' . $id;
        $konfirmasi_kembali = BASEURL . '/index.php?controller=admin&action=penumpang&sub_action=detail&id=' . $id;
        $konfirmasi_css_file = 'admin';
        require_once __DIR__ . '/../views/konfirmasi.php';
    }

    public function operator() {
        $sub_action = $_GET['sub_action'] ?? 'index';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($sub_action === 'add') $this->operatorAdd();
        elseif ($sub_action === 'edit' && $id) $this->operatorEdit($id);
        elseif ($sub_action === 'delete' && $id) $this->operatorDelete($id);
        else $this->operatorIndex();
    }

    private function operatorIndex() {
        $operators = $this->operatorModel->getAllOperators();
        $viewMode = 'list';
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/admin/adminOperator.php';
    }

    private function operatorAdd() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $nama = trim($_POST['nama'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($email) || empty($nama) || empty($password)) {
                $error = 'Semua field wajib diisi.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Format email tidak valid.';
            } elseif (strlen($password) < 8) {
                $error = 'Password minimal 8 karakter.';
            } elseif ($this->operatorModel->usernameOperatorExists($username)) {
                $error = 'Username sudah digunakan.';
            } elseif ($this->operatorModel->emailOperatorExists($email)) {
                $error = 'Email sudah terdaftar.';
            } else {
                if ($this->operatorModel->createOperator($username, $email, $password, $nama)) {
                    $this->logModel->createLog($_SESSION['admin_id'], "Menambah operator: $username", 'berhasil');
                    $_SESSION['success'] = 'Operator berhasil ditambahkan.';
                    header('Location: ' . BASEURL . '/index.php?controller=admin&action=operator');
                    exit;
                }
                $error = 'Gagal menambahkan operator.';
            }
        }
        $viewMode = 'form';
        $operator = null;
        require_once __DIR__ . '/../views/admin/adminOperator.php';
    }

    private function operatorEdit($id) {
        $operator = $this->operatorModel->getOperatorByIdAdmin($id);
        if (!$operator) {
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=operator');
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $username = trim($_POST['username'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($nama) || empty($email) || empty($username)) {
                $error = 'Nama, email, dan username wajib diisi.';
            } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = 'Format email tidak valid.';
            } elseif ($this->operatorModel->usernameOperatorExists($username, $id)) {
                $error = 'Username sudah digunakan operator lain.';
            } elseif ($this->operatorModel->emailOperatorExists($email, $id)) {
                $error = 'Email sudah digunakan operator lain.';
            } else {
                $data = ['nama' => $nama, 'email' => $email, 'username' => $username];
                if (!empty($password)) {
                    if (strlen($password) < 8) {
                        $error = 'Password minimal 8 karakter.';
                    } else {
                        $data['password'] = $password;
                    }
                }
                if (empty($error)) {
                    if ($this->operatorModel->updateOperator($id, $data)) {
                        $this->logModel->createLog($_SESSION['admin_id'], "Mengubah operator ID $id", 'berhasil');
                        $_SESSION['success'] = 'Operator berhasil diperbarui.';
                        header('Location: ' . BASEURL . '/index.php?controller=admin&action=operator');
                        exit;
                    }
                    $error = 'Gagal memperbarui operator.';
                }
            }
        }
        $viewMode = 'form';
        require_once __DIR__ . '/../views/admin/adminOperator.php';
    }

    private function operatorDelete($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            try {
                if ($this->operatorModel->deleteOperator($id)) {
                    $this->logModel->createLog($_SESSION['admin_id'], "Menghapus operator ID $id", 'berhasil');
                    $_SESSION['success'] = 'Operator berhasil dihapus.';
                }
            } catch (Exception $e) {
                $_SESSION['error'] = 'Gagal menghapus operator. Pastikan tidak ada bus/jadwal terkait.';
            }
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=operator');
            exit;
        }
        $konfirmasi_pesan   = 'Yakin ingin menghapus operator ini?';
        $konfirmasi_action  = BASEURL . '/index.php?controller=admin&action=operator&sub_action=delete&id=' . $id;
        $konfirmasi_kembali = BASEURL . '/index.php?controller=admin&action=operator';
        $konfirmasi_css_file = 'admin';
        require_once __DIR__ . '/../views/konfirmasi.php';
    }

    public function manajemenAdmin() {
        $sub_action = $_GET['sub_action'] ?? 'index';
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($sub_action === 'add') $this->adminAdd();
        elseif ($sub_action === 'edit' && $id) $this->adminEdit($id);
        elseif ($sub_action === 'delete' && $id) $this->adminDeleteAction($id);
        else $this->adminIndex();
    }

    private function adminIndex() {
        $admins = $this->adminModel->getAllAdmin();
        $viewMode = 'list';
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        require_once __DIR__ . '/../views/admin/adminManajemenAdmin.php';
    }

    private function adminAdd() {
        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $nama = trim($_POST['nama_lengkap'] ?? '');
            $password = $_POST['password'] ?? '';

            if (empty($username) || empty($nama) || empty($password)) {
                $error = 'Semua field wajib diisi.';
            } elseif (strlen($password) < 8) {
                $error = 'Password minimal 8 karakter.';
            } else {
                if ($this->adminModel->createAdmin($username, $password, $nama)) {
                    $this->logModel->createLog($_SESSION['admin_id'], "Menambah admin: $username", 'berhasil');
                    $_SESSION['success'] = 'Akun admin berhasil dibuat.';
                    header('Location: ' . BASEURL . '/index.php?controller=admin&action=manajemenAdmin');
                    exit;
                }
                $error = 'Gagal membuat akun. Username mungkin sudah digunakan.';
            }
        }
        $viewMode = 'form';
        $adminData = null;
        require_once __DIR__ . '/../views/admin/adminManajemenAdmin.php';
    }

    private function adminEdit($id) {
        $adminData = $this->adminModel->getAdminById($id);
        if (!$adminData) {
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=manajemenAdmin');
            exit;
        }

        $error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nama = trim($_POST['nama_lengkap'] ?? '');
            $status = $_POST['status'] ?? '';
            $password = $_POST['password'] ?? '';

            if (empty($nama) || empty($status)) {
                $error = 'Semua field wajib diisi.';
            } elseif (!in_array($status, ['aktif', 'inactive'])) {
                $error = 'Status tidak valid.';
            } else {
                $data = ['nama_lengkap' => $nama, 'status' => $status];
                if (!empty($password)) {
                    if (strlen($password) < 8) {
                        $error = 'Password minimal 8 karakter.';
                    } else {
                        $data['password'] = $password;
                    }
                }
                if (empty($error)) {
                    if ($this->adminModel->updateAdmin($id, $data)) {
                        $this->logModel->createLog($_SESSION['admin_id'], "Mengubah akun admin ID $id", 'berhasil');
                        $_SESSION['success'] = 'Akun admin berhasil diperbarui.';
                        header('Location: ' . BASEURL . '/index.php?controller=admin&action=manajemenAdmin');
                        exit;
                    }
                    $error = 'Gagal memperbarui akun admin.';
                }
            }
        }
        $viewMode = 'form';
        require_once __DIR__ . '/../views/admin/adminManajemenAdmin.php';
    }

    private function adminDeleteAction($id) {
        if ($id === (int)$_SESSION['admin_id']) {
            $_SESSION['error'] = 'Tidak bisa menghapus akun Anda sendiri.';
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=manajemenAdmin');
            exit;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($this->adminModel->deleteAdmin($id)) {
                $this->logModel->createLog($_SESSION['admin_id'], "Menghapus akun admin ID $id", 'berhasil');
                $_SESSION['success'] = 'Akun admin berhasil dihapus.';
            } else {
                $_SESSION['error'] = 'Gagal menghapus akun admin.';
            }
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=manajemenAdmin');
            exit;
        }
        $konfirmasi_pesan   = 'Yakin ingin menghapus akun admin ini?';
        $konfirmasi_action  = BASEURL . '/index.php?controller=admin&action=manajemenAdmin&sub_action=delete&id=' . $id;
        $konfirmasi_kembali = BASEURL . '/index.php?controller=admin&action=manajemenAdmin';
        $konfirmasi_css_file = 'admin';
        require_once __DIR__ . '/../views/konfirmasi.php';
    }
}
