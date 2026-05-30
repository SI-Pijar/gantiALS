<?php
define('BASEURL', 'http://localhost/gantiALS');
require_once __DIR__ . '/ALS/config/routes.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$page = $_GET['page'] ?? 'home';
$controller = $_GET['controller'] ?? null;
$action = $_GET['action'] ?? null;
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if (!$controller) {
    require_once __DIR__ . '/ALS/app/controllers/PenumpangController.php';
    $c = new PenumpangController();

    switch ($page) {
        case 'jadwal': $c->jadwal(); break;
        case 'pemesanan': $c->pemesanan(); break;
        case 'proses_pemesanan': $c->prosesPemesanan(); break;
        case 'pembayaran': $c->pembayaran(); break;
        case 'proses_pembayaran': $c->prosesPembayaran(); break;
        case 'tiket': $c->tiket(); break;
        case 'riwayat': $c->riwayat(); break;
        case 'profil': $c->profil(); break;
        case 'proses_ubah_profil': $c->prosesUbahProfil(); break;
        case 'proses_ganti_password': $c->prosesGantiPassword(); break;
        default: $c->index(); break;
    }
}

elseif ($controller === 'operator') {
    require_once __DIR__ . '/ALS/app/controllers/OperatorController.php';
    $c = new OperatorController();

    switch ($action) {
        case 'dashboard': $c->dashboard(); break;
        case 'bilList': $c->bilList(); break;
        case 'bilAdd': $c->bilAdd(); break;
        case 'bilEdit': if ($id) $c->bilEdit($id); break;
        case 'bilDelete': if ($id) $c->bilDelete($id); break;
        case 'jadwalList': $c->jadwalList(); break;
        case 'jadwalAdd': $c->jadwalAdd(); break;
        case 'jadwalEdit': if ($id) $c->jadwalEdit($id); break;
        case 'jadwalDelete': if ($id) $c->jadwalDelete($id); break;
        case 'pemesananList': $c->pemesananList(); break;
        case 'pemesananVerifikasi': if ($id) $c->pemesananVerifikasi($id); break;
        case 'pemesananTolak': if ($id) $c->pemesananTolak($id); break;
        case 'profil': $c->profil(); break;
        case 'prosesUbahProfil': $c->prosesUbahProfil(); break;
        case 'prosesGantiPassword': $c->prosesGantiPassword(); break;
        case 'login': $c->login(); break;
        case 'logout': $c->logout(); break;
        default: $c->login(); break;
    }
}

elseif ($controller === 'auth') {
    require_once __DIR__ . '/ALS/app/controllers/AuthController.php';
    $c = new AuthController();

    switch ($action) {
        case 'login':
            ($_SERVER['REQUEST_METHOD'] === 'POST') ? $c->login() : $c->loginForm();
            break;
        case 'register':
            ($_SERVER['REQUEST_METHOD'] === 'POST') ? $c->register() : $c->registerForm();
            break;
        case 'logout': $c->logout(); break;
        default: $c->loginForm(); break;
    }
}

elseif ($controller === 'admin') {
    require_once __DIR__ . '/ALS/app/controllers/AdminController.php';
    $c = new AdminController();

    switch ($action) {
        case 'dashboard': $c->dashboard(); break;
        case 'jadwal': $c->jadwal(); break;
        case 'transaksi': $c->transaksi(); break;
        case 'log': $c->log(); break;
        case 'penumpang': $c->penumpang(); break;
        case 'pengaturan': $c->pengaturan(); break;
        case 'operator': $c->operator(); break;
        case 'manajemenAdmin': $c->manajemenAdmin(); break;
        default: $c->dashboard(); break;
    }
}

else {
    header('Location: ' . BASEURL . '/index.php');
    exit;
}
