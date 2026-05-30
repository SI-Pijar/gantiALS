<?php
class Database {
    private $host;
    private $db_name;
    private $username;
    private $password;

    public function __construct() {
        $this->host = getenv('DB_HOST') ?: 'localhost';
        $this->db_name = getenv('DB_NAME') ?: 'cobaals';
        $this->username = getenv('DB_USER') ?: 'root';
        $this->password = getenv('DB_PASS') ?: '';
    }

    public function connect() {
        try {
            $conn = new PDO(
                "mysql:host={$this->host};dbname={$this->db_name};charset=utf8mb4",
                $this->username,
                $this->password,
                [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                ]
            );
            return $conn;
        } catch (PDOException $e) {
            $this->logDatabaseError($e);
            die('Database Error: Connection failed. Please contact administrator.');
        }
    }

    private function logDatabaseError(PDOException $e) {
        $log_file = __DIR__ . '/../../logs/database_errors.log';
        if (!is_dir(dirname($log_file))) {
            mkdir(dirname($log_file), 0755, true);
        }
        error_log('[' . date('Y-m-d H:i:s') . '] ' . $e->getMessage() . "\n", 3, $log_file);
    }
}
