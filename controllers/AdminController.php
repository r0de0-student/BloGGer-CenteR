<?php
class AdminController {
    private $userModel;
    
    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }
    
    public function users() {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
            header('Location: ' . BASE_PATH . '/?action=home');
            exit;
        }
        
        $users = $this->userModel->getAll();
        require_once __DIR__ . '/../views/admin/users.php';
    }
    
    public function toggleBlock($id) {
        if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
            header('Location: ' . BASE_PATH . '/?action=home');
            exit;
        }
        
        $this->userModel->toggleBlock($id);
        header('Location: ' . BASE_PATH . '/?action=admin-users');
        exit;
    }
}