<?php
class PostController {
    private $postModel;
    private $commentModel;
    public $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
        $this->postModel = new Post($pdo);
        $this->commentModel = new Comment($pdo);
    }
    
    public function view($id) {
        $this->postModel->incrementViews($id);
        $post = $this->postModel->getById($id);
        $comments = $this->commentModel->getByPostId($id);
        require_once __DIR__ . '/../views/posts/view.php';
    }
    
    public function createForm() {
        require_once __DIR__ . '/../views/posts/create.php';
    }
    
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/?action=login');
            exit;
        }
        
        $blogModel = new Blog($this->db);
        $blog = $blogModel->findByUserId($_SESSION['user_id']);
        
        if (!$blog) {
            $_SESSION['error'] = "Сначала создайте блог!";
            header('Location: ' . BASE_PATH . '/?action=my-blog');
            exit;
        }
        
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        
        if (empty($title)) {
            $_SESSION['error'] = "Заголовок обязателен!";
            header('Location: ' . BASE_PATH . '/?action=create-post');
            exit;
        }
        
        $this->postModel->create($blog['id'], $title, $content);
        $_SESSION['success'] = "Статья опубликована!";
        header('Location: ' . BASE_PATH . '/?action=my-blog');
        exit;
    }
    
    public function editForm($id) {
        $post = $this->postModel->getById($id);
        require_once __DIR__ . '/../views/posts/edit.php';
    }
    
    public function update($id) {
        $title = trim($_POST['title'] ?? '');
        $content = trim($_POST['content'] ?? '');
        
        if (empty($title)) {
            $_SESSION['error'] = "Заголовок обязателен!";
            header('Location: ' . BASE_PATH . '/?action=edit-post&id=' . $id);
            exit;
        }
        
        $this->postModel->update($id, $title, $content);
        $_SESSION['success'] = "Статья обновлена!";
        header('Location: ' . BASE_PATH . '/?action=my-blog');
        exit;
    }
    
    public function delete($id) {
        $this->postModel->delete($id);
        $_SESSION['success'] = "Статья удалена!";
        header('Location: ' . BASE_PATH . '/?action=my-blog');
        exit;
    }
    
    public function addComment($postId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/?action=login');
            exit;
        }
        
        $content = trim($_POST['content'] ?? '');
        if (!empty($content)) {
            $this->commentModel->create($postId, $_SESSION['user_id'], $content);
        }
        header('Location: ' . BASE_PATH . '/?action=view-post&id=' . $postId);
        exit;
    }
}