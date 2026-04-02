<?php
class Comment {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function create($postId, $userId, $content, $parentId = null) {
        $stmt = $this->db->prepare("INSERT INTO comments (post_id, user_id, content, parent_comment_id) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$postId, $userId, $content, $parentId]);
    }
    
    public function getByPostId($postId) {
        $stmt = $this->db->prepare("SELECT c.*, u.name as user_name 
                                     FROM comments c 
                                     JOIN users u ON c.user_id = u.id 
                                     WHERE c.post_id = ? AND c.is_deleted = FALSE 
                                     ORDER BY c.created_at ASC");
        $stmt->execute([$postId]);
        return $stmt->fetchAll();
    }
    
    public function delete($commentId) {
        $stmt = $this->db->prepare("UPDATE comments SET is_deleted = TRUE WHERE id = ?");
        return $stmt->execute([$commentId]);
    }
}