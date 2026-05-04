<?php
class Subscription {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    public function subscribe($userId, $blogId) {
        $stmt = $this->db->prepare("INSERT INTO subscriptions (subscriber_id, blog_id) VALUES (?, ?)");
        return $stmt->execute([$userId, $blogId]);
    }
    
    public function unsubscribe($userId, $blogId) {
        $stmt = $this->db->prepare("DELETE FROM subscriptions WHERE subscriber_id = ? AND blog_id = ?");
        return $stmt->execute([$userId, $blogId]);
    }
    
    public function isSubscribed($userId, $blogId) {
        $stmt = $this->db->prepare("SELECT * FROM subscriptions WHERE subscriber_id = ? AND blog_id = ?");
        $stmt->execute([$userId, $blogId]);
        return $stmt->fetch() ? true : false;
    }
    
    public function countByBlogId($blogId) {
        $stmt = $this->db->prepare("SELECT COUNT(*) as count FROM subscriptions WHERE blog_id = ?");
        $stmt->execute([$blogId]);
        return $stmt->fetch()['count'];
    }
}