<?php
class HomeController {
    private $postModel;
    
    public function __construct($pdo) {
        require_once __DIR__ . '/../models/Post.php';
        $this->postModel = new Post($pdo);
    }
    
    public function index() {
        $posts = $this->postModel->getAll();
        
        require_once __DIR__ . '/../views/home/index.php';
    }
}
?>