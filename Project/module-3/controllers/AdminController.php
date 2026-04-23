<?php
class AdminController {
    private $userModel;
    
    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }
    
    /**
     * Страница управления пользователями (только админ)
     */
    public function users() {
        // Защита: только администратор
        requireAdmin();
        
        $users = $this->userModel->getAll();
        require_once __DIR__ . '/../views/admin/users.php';
    }
    
    /**
     * Блокировка/разблокировка пользователя (только админ)
     */
    public function toggleBlock($id) {
        // Защита: только администратор
        requireAdmin();
        
        $this->userModel->toggleBlock($id);
        $_SESSION['success'] = "Статус пользователя изменён";
        header('Location: ' . BASE_PATH . '/?action=admin-users');
        exit;
    }
    
    /**
     * Редактирование роли пользователя (только админ)
     */
    public function editRole($id) {
        requireAdmin();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $role = $_POST['role'] ?? 'author';
            $this->userModel->updateRole($id, $role);
            $_SESSION['success'] = "Роль пользователя обновлена";
            header('Location: ' . BASE_PATH . '/?action=admin-users');
            exit;
        }
        
        $user = $this->userModel->findById($id);
        require_once __DIR__ . '/../views/admin/edit-role.php';
    }
    
    /**
     * Удаление пользователя (только админ)
     */
    public function delete($id) {
        requireAdmin();
        
        // Нельзя удалить самого себя
        if ($id == $_SESSION['user_id']) {
            $_SESSION['error'] = "Вы не можете удалить самого себя";
            header('Location: ' . BASE_PATH . '/?action=admin-users');
            exit;
        }
        
        $this->userModel->delete($id);
        $_SESSION['success'] = "Пользователь удалён";
        header('Location: ' . BASE_PATH . '/?action=admin-users');
        exit;
    }
}
?>