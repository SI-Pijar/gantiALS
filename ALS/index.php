<?php
define('BASEURL', 'http://localhost/gantiALS');
require_once __DIR__ . '/app/controllers/OperatorController.php';
require_once __DIR__ . '/app/controllers/AuthController.php';

$controller = isset($_GET['controller']) ? $_GET['controller'] : 'operator';
$action = isset($_GET['action']) ? $_GET['action'] : 'login';
$id = isset($_GET['id']) ? (int)$_GET['id'] : null;

if ($controller === 'operator') {
    $operatorController = new OperatorController();

    switch ($action) {
        case 'dashboard':
            $operatorController->dashboard();
            break;
        
        case 'bilList':
            $operatorController->bilList();
            break;
        case 'bilAdd':
            $operatorController->bilAdd();
            break;
        case 'bilEdit':
            if ($id) {
                $operatorController->bilEdit($id);
            }
            break;
        case 'bilDelete':
            if ($id) {
                $operatorController->bilDelete($id);
            }
            break;
        
        case 'jadwalList':
            $operatorController->jadwalList();
            break;
        case 'jadwalAdd':
            $operatorController->jadwalAdd();
            break;
        case 'jadwalEdit':
            if ($id) {
                $operatorController->jadwalEdit($id);
            }
            break;
        case 'jadwalDelete':
            if ($id) {
                $operatorController->jadwalDelete($id);
            }
            break;
        
        case 'pemesananList':
            $operatorController->pemesananList();
            break;
        case 'pemesananVerifikasi':
            if ($id) {
                $operatorController->pemesananVerifikasi($id);
            }
            break;
        case 'pemesananTolak':
            if ($id) {
                $operatorController->pemesananTolak($id);
            }
            break;
        
        case 'logout':
            $operatorController->logout();
            break;
        
        case 'login':
        default:
            $operatorController->login();
            break;
    }
}
?>
