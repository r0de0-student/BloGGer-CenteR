<?php
class Post {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function create($blogId, $title, $content) {
        $stmt = $this->db->prepare("INSERT INTO posts (blog_id, title, content) VALUES (?, ?, ?)");
        return $stmt->execute([$blogId, $title, $content]);
    }
    
    public function getById($id) {
        $stmt = $this->db->prepare("SELECT p.*, b.user_id as author_id, b.name as blog_name, u.name as author_name
                                     FROM posts p 
                                     JOIN blogs b ON p.blog_id = b.id 
                                     JOIN users u ON b.user_id = u.id
                                     WHERE p.id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    public function incrementViews($postId) {
        $stmt = $this->db->prepare("UPDATE posts SET views_count = views_count + 1 WHERE id = ?");
        $stmt->execute([$postId]);
    }
    
    public function getByBlogId($blogId) {
        $stmt = $this->db->prepare("SELECT * FROM posts WHERE blog_id = ? ORDER BY created_at DESC");
        $stmt->execute([$blogId]);
        return $stmt->fetchAll();
    }
    
    public function getAll() {
        $stmt = $this->db->query("SELECT p.*, b.name as blog_name, u.name as author_name
                                   FROM posts p 
                                   JOIN blogs b ON p.blog_id = b.id 
                                   JOIN users u ON b.user_id = u.id
                                   ORDER BY p.created_at DESC");
        return $stmt->fetchAll();
    }
    
    public function update($id, $title, $content) {
        $stmt = $this->db->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
        return $stmt->execute([$title, $content, $id]);
    }
    
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM posts WHERE id = ?");
        return $stmt->execute([$id]);
    }
}