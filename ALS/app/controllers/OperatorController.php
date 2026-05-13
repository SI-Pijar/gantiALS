<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/OperatorModel.php';

class OperatorController {

    public function dashboard() {

        require_once __DIR__ . '/../views/operator/dashboard.php';
    }

    public function kelolaBus() {

        $database = new Database();
        $db = $database->connect();

        $operatorModel = new OperatorModel($db);

        $bus = $operatorModel->getAllBus();

        require_once __DIR__ . '/../views/operator/kelolaBus.php';
    }

    public function kelolaJadwal() {

        $database = new Database();
        $db = $database->connect();

        $operatorModel = new OperatorModel($db);

        $jadwal = $operatorModel->getAllJadwal();

        require_once __DIR__ . '/../views/operator/kelolaJadwal.php';
    }

    public function kelolaPemesanan() {

        $database = new Database();
        $db = $database->connect();

        $operatorModel = new OperatorModel($db);

        $pemesanan = $operatorModel->getAllPemesanan();

        require_once __DIR__ . '/../views/operator/kelolaPemesanan.php';
    }
}
?>