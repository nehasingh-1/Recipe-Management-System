<?php
session_start();

class Auth {
    private $db;
    public function __construct($db) { $this->db = $db; }

    public function login($u, $p) {
        $stmt = $this->db->pdo->prepare("SELECT id, password_hash FROM users WHERE username=?");
        $stmt->execute([$u]);
        $r = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($r && password_verify($p, $r['password_hash'])) {
            $_SESSION['user_id'] = $r['id'];
            return true;
        }
        return false;
    }

    public function check() {
        return isset($_SESSION['user_id']);
    }

    public function logout() {
        session_destroy();
        header("Location: login.php");
        exit;
    }
}
