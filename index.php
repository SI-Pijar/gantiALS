<?php
define('BASEURL', 'http://localhost/ALS1/ALS/public');
require_once __DIR__ . '/ALS/app/controllers/PenumpangController.php';
$controller = new PenumpangController();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
switch ($page) {
    case 'jadwal':
        $controller->jadwal();
        break;
    case 'pemesanan':
        $controller->pemesanan();
        break;
    case 'proses_pemesanan':
        $controller->prosesPemesanan();
        break;
    case 'tiket':
        $controller->tiket();
        break;
    case 'pembayaran':
        $controller->pembayaran();
        break;
    case 'proses_pembayaran':
        $controller->prosesPembayaran();
        break;
    default:
        $controller->index();
        break;
}