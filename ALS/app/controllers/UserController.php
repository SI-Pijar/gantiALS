<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController {

    public function index() {
        $database = new Database();
        $db = $database->connect();
        $userModel = new UserModel($db);
        $users = $userModel->getAllUsers();

        require_once __DIR__ . '/../views/user/home.php';
    }

    public function jadwal() {
        require_once __DIR__ . '/../views/user/jadwal.php';
    }

    public function pemesanan() {
        require_once __DIR__ . '/../views/user/pemesanan.php';
    }

    public function pembayaran() {
        require_once __DIR__ . '/../views/user/pembayaran.php';
    }
}