<?php

require_once __DIR__ . '/app/controllers/UserController.php';
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/controllers/DashboardController.php';
require_once __DIR__ . '/app/controllers/JadwalController.php';
require_once __DIR__ . '/app/controllers/PenggunaController.php';
require_once __DIR__ . '/app/controllers/TransaksiController.php';

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {

    // USER
    case 'jadwal':
        $controller = new UserController();
        $controller->jadwal();
        break;

    case 'pemesanan':
        $controller = new UserController();
        $controller->pemesanan();
        break;

    case 'pembayaran':
        $controller = new UserController();
        $controller->pembayaran();
        break;

    // LOGIN
    case 'login':
        $controller = new AuthController();
        $controller->login();
        break;

    // DASHBOARD ADMIN
    case 'dashboard':
        $controller = new DashboardController();
        $controller->index();
        break;

    // KELOLA JADWAL
    case 'kelola-jadwal':
        $controller = new JadwalController();
        $controller->index();
        break;

    // KELOLA PENGGUNA
    case 'pengguna':
        $controller = new PenggunaController();
        $controller->index();
        break;

    // TRANSAKSI
    case 'transaksi':
        $controller = new TransaksiController();
        $controller->index();
        break;

    // DEFAULT
    default:
        $controller = new UserController();
        $controller->index();
        break;
}