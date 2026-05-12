<?php

require_once __DIR__ . '/../../config/Database.php';
require_once __DIR__ . '/../models/UserModel.php';

class UserController {

    public function index() {

        $database = new Database();
        $db = $database->connect();

        $userModel = new UserModel($db);

        $users = $userModel->getAllUsers();

        require_once __DIR__ . '/../views/user/index.php';
    }
}