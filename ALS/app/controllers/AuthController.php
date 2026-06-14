<?php
require_once __DIR__ . '/../../config/database.php';
require_once __DIR__ . '/../models/AdminModel.php';
require_once __DIR__ . '/../models/OperatorModel.php';
require_once __DIR__ . '/../models/PenumpangModel.php';
require_once __DIR__ . '/../models/LogModel.php';

class AuthController {
    private $db;

    public function __construct() {
        if (session_status() === PHP_SESSION_NONE) session_start();
        $this->db = (new Database())->connect();
    }

    private function tampilForm($mode, $error = '') {
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        require_once __DIR__ . '/../views/auth/login.php';
    }

    public function loginForm() {
        $mode = 'login';
        $this->tampilForm($mode);
    }

    public function registerForm() {
        $mode = 'register';
        $this->tampilForm($mode);
    }

    public function login() {
        $credential = trim($_POST['credential'] ?? '');
        $password   = $_POST['password'] ?? '';

        if (empty($credential) || empty($password)) {
            $mode = 'login';
            $error = 'Username/email dan password wajib diisi.';
            $this->tampilForm($mode, $error);
            return;
        }

        $adminModel    = new AdminModel($this->db);
        $operatorModel = new OperatorModel($this->db);
        $penumpangModel = new PenumpangModel($this->db);

        $admin = $adminModel->getAdminByUsername($credential);
        if ($admin && password_verify($password, $admin['password'])) {
            if ($admin['status'] !== 'aktif') {
                $mode = 'login';
                $error = 'Akun admin Anda dinonaktifkan.';
                $this->tampilForm($mode, $error);
                return;
            }
            $_SESSION['admin_id']       = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            $_SESSION['admin_nama']     = $admin['nama_lengkap'];
            $_SESSION['admin_role']     = $admin['role'];
            (new LogModel($this->db))->createLog($admin['id'], 'Login ke sistem sebagai admin', 'info');
            header('Location: ' . BASEURL . '/index.php?controller=admin&action=dashboard');
            exit;
        }

        $operator = $operatorModel->findOperatorByEmailOrUsername($credential);
        if ($operator && password_verify($password, $operator['password'])) {
            $_SESSION['operator_id']    = $operator['id'];
            $_SESSION['nama_operator']  = $operator['nama'];
            header('Location: ' . BASEURL . '/index.php?controller=operator&action=dashboard');
            exit;
        }

        $penumpang = $penumpangModel->getPenumpangByEmailOrName($credential);
        if ($penumpang && password_verify($password, $penumpang['password'])) {
            if ($penumpang['status'] === 'suspended') {
                $mode = 'login';
                $error = 'Akun Anda telah dinonaktifkan. Hubungi administrator.';
                $this->tampilForm($mode, $error);
                return;
            }
            $_SESSION['penumpang_id']    = $penumpang['id'];
            $_SESSION['penumpang_name']  = $penumpang['nama_lengkap'];
            $_SESSION['penumpang_email'] = $penumpang['email'];
            header('Location: ' . BASEURL . '/index.php?page=home');
            exit;
        }

        $mode  = 'login';
        $error = 'Username/email atau password salah.';
        $this->tampilForm($mode, $error);
    }

    public function register() {
        $nama      = trim($_POST['nama'] ?? '');
        $email     = trim($_POST['email'] ?? '');
        $password  = $_POST['password'] ?? '';
        $password2 = $_POST['password2'] ?? '';
        $error     = '';

        if (empty($nama) || empty($email) || empty($password) || empty($password2)) {
            $error = 'Semua field wajib diisi.';
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $error = 'Email tidak valid.';
        } elseif ($password !== $password2) {
            $error = 'Password dan konfirmasi password tidak sama.';
        } elseif (strlen($password) < 8) {
            $error = 'Password minimal 8 karakter.';
        }

        if ($error) {
            $mode = 'register';
            $this->tampilForm($mode, $error);
            return;
        }

        $penumpangModel = new PenumpangModel($this->db);

        if ($penumpangModel->emailExists($email)) {
            $mode  = 'register';
            $error = 'Email sudah terdaftar.';
            $this->tampilForm($mode, $error);
            return;
        }

        if ($penumpangModel->createPenumpang($nama, $email, $password)) {
            $_SESSION['success'] = 'Pendaftaran berhasil. Silakan masuk.';
            header('Location: ' . BASEURL . '/index.php?controller=auth&action=login');
            exit;
        }

        $mode  = 'register';
        $error = 'Gagal mendaftar. Silakan coba lagi.';
        $this->tampilForm($mode, $error);
    }

    public function logout() {
        if (isset($_SESSION['admin_id'])) {
            (new LogModel($this->db))->createLog($_SESSION['admin_id'], 'Logout dari sistem', 'info');
        }
        session_destroy();
        header('Location: ' . BASEURL . '/index.php?controller=auth&action=login');
        exit;
    }
}
