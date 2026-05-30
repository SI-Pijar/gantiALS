<?php
class AdminModel {
    private $conn;
    private $table = 'admins';

    public function __construct($db) {
        $this->conn = $db;
    }

    public function getAdminByUsername($username) {
        $stmt = $this->conn->prepare("SELECT * FROM {$this->table} WHERE username = :username LIMIT 1");
        $stmt->execute([':username' => $username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAdminById($id) {
        $stmt = $this->conn->prepare(
            "SELECT id, username, nama_lengkap, status FROM {$this->table} WHERE id = :id LIMIT 1"
        );
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAllAdmin() {
        $stmt = $this->conn->prepare(
            "SELECT id, username, nama_lengkap, status, created_at FROM {$this->table} ORDER BY created_at DESC"
        );
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function usernameExists($username, $exclude_id = null) {
        if ($exclude_id) {
            $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE username = :u AND id != :id LIMIT 1");
            $stmt->execute([':u' => $username, ':id' => $exclude_id]);
        } else {
            $stmt = $this->conn->prepare("SELECT id FROM {$this->table} WHERE username = :u LIMIT 1");
            $stmt->execute([':u' => $username]);
        }
        return $stmt->fetch() !== false;
    }

    public function createAdmin($username, $password, $nama_lengkap) {
        if ($this->usernameExists($username)) return false;

        $stmt = $this->conn->prepare(
            "INSERT INTO {$this->table} (username, password, nama_lengkap, role, status)
             VALUES (:username, :password, :nama_lengkap, 'admin', 'aktif')"
        );
        return $stmt->execute([
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_BCRYPT, ['cost' => 12]),
            ':nama_lengkap' => $nama_lengkap,
        ]);
    }

    public function updateAdmin($id, $data) {
        $allowed = ['nama_lengkap', 'status'];
        $sets = [];
        $params = [':id' => $id];

        foreach ($allowed as $field) {
            if (isset($data[$field])) {
                $sets[] = "$field = :$field";
                $params[":$field"] = $data[$field];
            }
        }
        if (isset($data['password']) && !empty($data['password'])) {
            $sets[] = 'password = :password';
            $params[':password'] = password_hash($data['password'], PASSWORD_BCRYPT, ['cost' => 12]);
        }

        if (empty($sets)) return false;

        $stmt = $this->conn->prepare("UPDATE {$this->table} SET " . implode(', ', $sets) . " WHERE id = :id");
        return $stmt->execute($params);
    }

    public function deleteAdmin($id) {
        $stmt = $this->conn->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount() > 0;
    }
}
