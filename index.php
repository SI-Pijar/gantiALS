<?php
define('BASEURL', 'http://localhost/gantiALS');
require_once __DIR__ . '/ALS/app/controllers/PenumpangController.php';
require_once __DIR__ . '/ALS/app/controllers/OperatorController.php';

$penumpangController = new PenumpangController();
$operatorController = new OperatorController();

$page = isset($_GET['page']) ? $_GET['page'] : 'home';

switch ($page) {
    // Penumpang Routes
    case 'jadwal':
        $penumpangController->jadwal();
        break;
    case 'pemesanan':
        $penumpangController->pemesanan();
        break;
    case 'proses_pemesanan':
        $penumpangController->prosesPemesanan();
        break;
    case 'tiket':
        $penumpangController->tiket();
        break;
    case 'pembayaran':
        $penumpangController->pembayaran();
        break;
    case 'proses_pembayaran':
        $penumpangController->prosesPembayaran();
        break;

    // Operator Routes
    case 'operatorDashboard':
        $operatorController->dashboard();
        break;
    case 'operatorJadwal':
        $operatorController->jadwal();
        break;
    case 'operatorBus':
        $operatorController->bus();
        break;
    case 'operatorPemesanan':
        $operatorController->pemesanan();
        break;
    case 'operatorLogin':
        $operatorController->login();
        break;

    default:
        $penumpangController->index();
        break;
}
