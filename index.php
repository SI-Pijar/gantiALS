<?php
define('BASEURL', 'http://localhost/ALS1/ALS/public');
require_once __DIR__ . '/app/controllers/UserController.php';
$controller = new UserController();
$page = isset($_GET['page']) ? $_GET['page'] : 'home';
switch ($page) {
    case 'jadwal':
        $controller->jadwal();
        break;
    case 'pemesanan':
        $controller->pemesanan();
        break;
    case 'pembayaran':
        $controller->pembayaran();
        break;
    default:
        $controller->index();
        break;
}