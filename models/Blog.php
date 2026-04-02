<?php
class Blog {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function findByUserId($userId) {
        $stmt = $this->db->prepare("SELECT * FROM blogs WHERE user_id = ?");
        $stmt->execute([$userId]);
        return $stmt->fetch();
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT b.*, u.name as owner_name 
                                     FROM blogs b 
                                     JOIN users u ON b.user_id = u.id 
                                     WHERE b.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function create($userId, $name, $description) {
        $stmt = $this->db->prepare("INSERT INTO blogs (user_id, name, description) VALUES (?, ?, ?)");
        return $stmt->execute([$userId, $name, $description]);
    }
    
    public function update($id, $name, $description) {
        $stmt = $this->db->prepare("UPDATE blogs SET name = ?, description = ? WHERE id = ?");
        return $stmt->execute([$name, $description, $id]);
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT b.*, u.name as owner_name, 
                                   (SELECT COUNT(*) FROM posts WHERE blog_id = b.id) as posts_count,
                                   (SELECT COUNT(*) FROM subscriptions WHERE blog_id = b.id) as subscribers_count
                                   FROM blogs b 
                                   JOIN users u ON b.user_id = u.id 
                                   ORDER BY b.created_at DESC");
        return $stmt->fetchAll();
    }
}