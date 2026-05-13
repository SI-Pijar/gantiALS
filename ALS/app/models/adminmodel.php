<?php
class AdminModel {
    private $conn;
    private $table = 'admins';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAllAdmins() {
        $query = 'SELECT id, username, nama_lengkap, role, status, created_at
                  FROM ' . $this->table . '
                  ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    public function getAdminById($id) {
        $query = 'SELECT id, username, nama_lengkap, role, status
                  FROM ' . $this->table . '
                  WHERE id = :id LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdminByUsername($username) {
        $query = 'SELECT * FROM ' . $this->table . ' WHERE username = :username LIMIT 1';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function countAdmins() {
        $query = 'SELECT COUNT(*) as total FROM ' . $this->table;
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['total'];
    }

    public function createAdmin($username, $nama_lengkap, $password, $role, $status) {
        $query = 'INSERT INTO ' . $this->table . '
                  (username, nama_lengkap, password, role, status)
                  VALUES (:username, :nama_lengkap, :password, :role, :status)';
        $stmt = $this->conn->prepare($query);
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $stmt->bindParam(':username',     $username);
        $stmt->bindParam(':nama_lengkap', $nama_lengkap);
        $stmt->bindParam(':password',     $hashed);
        $stmt->bindParam(':role',         $role);
        $stmt->bindParam(':status',       $status);
        return $stmt->execute();
    }

    public function updateAdmin($id, $nama_lengkap, $role, $status, $password = null) {
        if ($password) {
            $query = 'UPDATE ' . $this->table . '
                      SET nama_lengkap = :nama_lengkap, role = :role,
                          status = :status, password = :password
                      WHERE id = :id';
        } else {
            $query = 'UPDATE ' . $this->table . '
                      SET nama_lengkap = :nama_lengkap, role = :role, status = :status
                      WHERE id = :id';
        }
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id',           $id);
        $stmt->bindParam(':nama_lengkap', $nama_lengkap);
        $stmt->bindParam(':role',         $role);
        $stmt->bindParam(':status',       $status);
        if ($password) {
            $hashed = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashed);
        }
        return $stmt->execute();
    }

    public function deleteAdmin($id) {
        $query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function toggleStatus($id, $status) {
        $query = 'UPDATE ' . $this->table . ' SET status = :status WHERE id = :id';
        $stmt  = $this->conn->prepare($query);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':id',     $id);
        return $stmt->execute();
    }
}
