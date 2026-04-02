<?php
class User {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($name, $email, $password) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'reader')");
        return $stmt->execute([$name, $email, $hashed]);
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function toggleBlock($userId) {
        $stmt = $this->db->prepare("UPDATE users SET is_blocked = NOT is_blocked WHERE id = ?");
        return $stmt->execute([$userId]);
    }
    
    public function updateRole($userId, $role) {
        $stmt = $this->db->prepare("UPDATE users SET role = ? WHERE id = ?");
        return $stmt->execute([$role, $userId]);
    }
}