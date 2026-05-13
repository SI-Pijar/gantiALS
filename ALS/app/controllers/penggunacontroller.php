<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/LogModel.php';

class PenggunaController {

    public function index() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $database   = new Database();
        $db         = $database->connect();
        $adminModel = new AdminModel($db);
        $pengguna   = $adminModel->getAllAdmins();

        require_once __DIR__ . '/../views/admin/pengguna/index.php';
    }

    public function tambahForm() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $user = null;
        require_once __DIR__ . '/../views/admin/pengguna/form.php';
    }

    public function tambah() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $username    = trim($_POST['username']     ?? '');
        $namaLengkap = trim($_POST['nama_lengkap'] ?? '');
        $password    = $_POST['password'] ?? '';
        $role        = $_POST['role']     ?? 'pengguna';
        $status      = $_POST['status']   ?? 'aktif';

        if (empty($username) || empty($namaLengkap) || empty($password)) {
            $error = 'Username, nama lengkap, dan password wajib diisi.';
            $user  = null;
            require_once __DIR__ . '/../views/admin/pengguna/form.php';
            return;
        }

        $database   = new Database();
        $db         = $database->connect();
        $adminModel = new AdminModel($db);

        if ($adminModel->getAdminByUsername($username)) {
            $error = 'Username sudah digunakan.';
            $user  = null;
            require_once __DIR__ . '/../views/admin/pengguna/form.php';
            return;
        }

        $berhasil = $adminModel->createAdmin($username, $namaLengkap, $password, $role, $status);

        if ($berhasil) {
            $logModel = new LogModel($db);
            $logModel->createLog($_SESSION['admin_id'], "Menambahkan pengguna baru: $username ($role)", 'berhasil');
            $success = 'Pengguna berhasil ditambahkan.';
        } else {
            $error = 'Gagal menambahkan pengguna.';
        }

        $pengguna = $adminModel->getAllAdmins();
        require_once __DIR__ . '/../views/admin/pengguna/index.php';
    }

    public function editForm() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id         = (int)($_GET['id'] ?? 0);
        $database   = new Database();
        $db         = $database->connect();
        $adminModel = new AdminModel($db);
        $user       = $adminModel->getAdminById($id);

        if (!$user) {
            header('Location: index.php?page=pengguna');
            exit;
        }

        require_once __DIR__ . '/../views/admin/pengguna/form.php';
    }

    public function edit() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id          = (int)($_POST['id']            ?? 0);
        $namaLengkap = trim($_POST['nama_lengkap']   ?? '');
        $role        = $_POST['role']     ?? 'pengguna';
        $status      = $_POST['status']   ?? 'aktif';
        $password    = $_POST['password'] ?? '';

        $database   = new Database();
        $db         = $database->connect();
        $adminModel = new AdminModel($db);
        $berhasil   = $adminModel->updateAdmin($id, $namaLengkap, $role, $status, $password ?: null);

        if ($berhasil) {
            $logModel = new LogModel($db);
            $logModel->createLog($_SESSION['admin_id'], "Mengubah data pengguna ID#$id", 'berhasil');
            $success = 'Data pengguna berhasil diperbarui.';
        } else {
            $error = 'Gagal memperbarui pengguna.';
        }

        $pengguna = $adminModel->getAllAdmins();
        require_once __DIR__ . '/../views/admin/pengguna/index.php';
    }

    public function hapus() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id = (int)($_GET['id'] ?? 0);

        if ($id === (int)$_SESSION['admin_id']) {
            $error = 'Tidak dapat menghapus akun Anda sendiri.';
            $database   = new Database();
            $db         = $database->connect();
            $adminModel = new AdminModel($db);
            $pengguna   = $adminModel->getAllAdmins();
            require_once __DIR__ . '/../views/admin/pengguna/index.php';
            return;
        }

        $database   = new Database();
        $db         = $database->connect();
        $adminModel = new AdminModel($db);
        $user       = $adminModel->getAdminById($id);

        if ($user && $adminModel->deleteAdmin($id)) {
            $logModel = new LogModel($db);
            $logModel->createLog($_SESSION['admin_id'], "Menghapus pengguna: {$user['username']}", 'berhasil');
            $success = 'Pengguna berhasil dihapus.';
        } else {
            $error = 'Gagal menghapus pengguna.';
        }

        $pengguna = $adminModel->getAllAdmins();
        require_once __DIR__ . '/../views/admin/pengguna/index.php';
    }

    public function toggleStatus() {
        session_start();
        if (!isset($_SESSION['admin_id'])) {
            header('Location: index.php?page=login');
            exit;
        }

        $id         = (int)($_GET['id'] ?? 0);
        $database   = new Database();
        $db         = $database->connect();
        $adminModel = new AdminModel($db);
        $user       = $adminModel->getAdminById($id);

        if ($user) {
            $newStatus = ($user['status'] === 'aktif') ? 'nonaktif' : 'aktif';
            $adminModel->toggleStatus($id, $newStatus);
            $logModel = new LogModel($db);
            $logModel->createLog($_SESSION['admin_id'], "Mengubah status {$user['username']} menjadi $newStatus", 'berhasil');
            $success = "Status pengguna diubah menjadi $newStatus.";
        } else {
            $error = 'Pengguna tidak ditemukan.';
        }

        $pengguna = $adminModel->getAllAdmins();
        require_once __DIR__ . '/../views/admin/pengguna/index.php';
    }
}
