<?php
class BlogController {
    private $blogModel;
    private $postModel;
    
    public function __construct($pdo) {
        $this->blogModel = new Blog($pdo);
        $this->postModel = new Post($pdo);
    }
    
    public function myBlog() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/?action=login');
            exit;
        }
        
        $blog = $this->blogModel->findByUserId($_SESSION['user_id']);
        $posts = $blog ? $this->postModel->getByBlogId($blog['id']) : [];
        require_once __DIR__ . '/../views/blog/my-blog.php';
    }
    
    public function createForm() {
        require_once __DIR__ . '/../views/blog/create.php';
    }
    
    public function create() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/?action=login');
            exit;
        }
        
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if (empty($name)) {
            $_SESSION['error'] = "Название блога обязательно!";
            header('Location: ' . BASE_PATH . '/?action=create-blog');
            exit;
        }
        
        $this->blogModel->create($_SESSION['user_id'], $name, $description);
        $_SESSION['success'] = "Блог создан!";
        header('Location: ' . BASE_PATH . '/?action=my-blog');
        exit;
    }
    
    public function editForm() {
        $blog = $this->blogModel->findByUserId($_SESSION['user_id']);
        require_once __DIR__ . '/../views/blog/edit.php';
    }
    
    public function update() {
        $blog = $this->blogModel->findByUserId($_SESSION['user_id']);
        $name = trim($_POST['name'] ?? '');
        $description = trim($_POST['description'] ?? '');
        
        if (empty($name)) {
            $_SESSION['error'] = "Название блога обязательно!";
            header('Location: ' . BASE_PATH . '/?action=edit-blog');
            exit;
        }
        
        $this->blogModel->update($blog['id'], $name, $description);
        $_SESSION['success'] = "Блог обновлён!";
        header('Location: ' . BASE_PATH . '/?action=my-blog');
        exit;
    }
    
    public function allBlogs() {
        $blogs = $this->blogModel->getAll();
        require_once __DIR__ . '/../views/blog/all.php';
    }
}