<?php
require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/LogModel.php';

class AuthController {

    public function loginForm() {
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function login() {
        session_start();

        $username = trim($_POST['username'] ?? '');
        $password = $_POST['password'] ?? '';

        if (empty($username) || empty($password)) {
            $error = 'Username dan password wajib diisi.';
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        $database   = new Database();
        $db         = $database->connect();
        $adminModel = new AdminModel($db);
        $admin      = $adminModel->getAdminByUsername($username);

        if (!$admin || !password_verify($password, $admin['password'])) {
            $error = 'Username atau password salah.';
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        if ($admin['status'] !== 'aktif') {
            $error = 'Akun Anda dinonaktifkan. Hubungi Super Admin.';
            require_once __DIR__ . '/../views/auth/login.php';
            return;
        }

        $_SESSION['admin_id']       = $admin['id'];
        $_SESSION['admin_username'] = $admin['username'];
        $_SESSION['admin_nama']     = $admin['nama_lengkap'];
        $_SESSION['admin_role']     = $admin['role'];

        $logModel = new LogModel($db);
        $logModel->createLog($admin['id'], 'Login ke sistem', 'info');

        header('Location: index.php?page=dashboard');
        exit;
    }

    public function logout() {
        session_start();

        if (isset($_SESSION['admin_id'])) {
            $database = new Database();
            $db       = $database->connect();
            $logModel = new LogModel($db);
            $logModel->createLog($_SESSION['admin_id'], 'Logout dari sistem', 'info');
        }

        session_destroy();
        header('Location: index.php?page=login');
        exit;
    }
}
