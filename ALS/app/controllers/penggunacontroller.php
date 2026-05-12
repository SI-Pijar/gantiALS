<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/AdminModel.php';

class PenggunaController {

    public function index() {

        $database = new Database();
        $db = $database->connect();
        $adminModel = new AdminModel($db);
        $pengguna = $adminModel->findAll();

        require_once __DIR__ . '/../views/admin/kelolaPengguna.php';
    }

    public function tambah() {

        $database = new Database();
        $db = $database->connect();

        $adminModel = new AdminModel($db);

        $data = [
            'username' => $_POST['username'],
            'nama_lengkap' => $_POST['nama_lengkap'],
            'password' => password_hash($_POST['password'], PASSWORD_DEFAULT),
            'role' => $_POST['role'],
            'status' => $_POST['status']
        ];

        $adminModel->insert($data);

        header("Location: pengguna.php");
        exit;
    }

    public function edit($id) {

        $database = new Database();
        $db = $database->connect();

        $adminModel = new AdminModel($db);
        $data = [
            'nama_lengkap' => $_POST['nama_lengkap'],
            'role' => $_POST['role'],
            'status' => $_POST['status']
        ];

        $adminModel->update($id, $data);

        header("Location: pengguna.php");
        exit;
    }

    public function hapus($id) {

        $database = new Database();
        $db = $database->connect();
        $adminModel = new AdminModel($db);
        $adminModel->delete($id);

        header("Location: pengguna.php");
        exit;
    }
}