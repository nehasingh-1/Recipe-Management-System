<?php
class Database {
    private $host = 'localhost', $db = 'recipes_db', $user = 'root', $pass = '';
    public $pdo;
    public function __construct() {
        $dsn = "mysql:host={$this->host};dbname={$this->db};charset=utf8mb4";
        $this->pdo = new PDO($dsn, $this->user, $this->pass, [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }
}
