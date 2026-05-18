<?php
<<<<<<< HEAD
define('BASEURL', 'http://localhost/ALS1/ALS/public');
require_once __DIR__ . '/app/controllers/UserController.php';
$controller = new UserController();
=======
define('BASEURL', 'http://localhost/gantiALS');
require_once __DIR__ . '/ALS/app/controllers/PenumpangController.php';
require_once __DIR__ . '/ALS/app/controllers/OperatorController.php';

$penumpangController = new PenumpangController();
$operatorController = new OperatorController();

>>>>>>> b707894dbeeb19f3b91a36119529d92c5c40b53a
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
