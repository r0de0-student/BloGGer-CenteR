<?php
class AuthController {
    private $userModel;
    
    public function __construct($pdo) {
        $this->userModel = new User($pdo);
    }
    
    /**
     * Показать форму входа
     */
    public function loginForm() {
        require_once __DIR__ . '/../views/auth/login.php';
    }
    
    /**
     * Обработка входа в систему
     */
    public function login() {
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        $user = $this->userModel->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            if ($user['is_blocked']) {
                $_SESSION['error'] = "Ваш аккаунт заблокирован!";
                header('Location: ' . BASE_PATH . '/?action=login');
                exit;
            }
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            header('Location: ' . BASE_PATH . '/?action=home');
            exit;
        } else {
            $_SESSION['error'] = "Неверный email или пароль!";
            header('Location: ' . BASE_PATH . '/?action=login');
            exit;
        }
    }
    
    /**
     * Показать форму регистрации
     */
    public function registerForm() {
        require_once __DIR__ . '/../views/auth/register.php';
    }
    
    /**
     * Обработка регистрации (все становятся авторами)
     */
    public function register() {
        $name = trim($_POST['name'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        
        $errors = [];
        if (empty($name)) $errors[] = "Имя обязательно";
        if (empty($email)) $errors[] = "Email обязателен";
        if (strlen($password) < 6) $errors[] = "Пароль должен быть минимум 6 символов";
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) $errors[] = "Неверный формат email";
        
        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            header('Location: ' . BASE_PATH . '/?action=register');
            exit;
        }
        
        if ($this->userModel->create($name, $email, $password)) {
            $_SESSION['success'] = "Регистрация успешна! Теперь вы автор. Войдите в систему.";
            header('Location: ' . BASE_PATH . '/?action=login');
            exit;
        } else {
            $_SESSION['error'] = "Email уже зарегистрирован!";
            header('Location: ' . BASE_PATH . '/?action=register');
            exit;
        }
    }
    
    /**
     * Выход из системы
     */
    public function logout() {
        session_destroy();
        header('Location: ' . BASE_PATH . '/?action=home');
        exit;
    }
    
    /**
     * Повысить читателя до автора (если ещё есть reader)
     */
    public function becomeAuthor() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: ' . BASE_PATH . '/?action=login');
            exit;
        }
        
        $this->userModel->upgradeToAuthor($_SESSION['user_id']);
        $_SESSION['role'] = 'author';
        $_SESSION['success'] = "Поздравляем! Теперь вы автор. Создайте свой блог!";
        
        header('Location: ' . BASE_PATH . '/?action=my-blog');
        exit;
    }
}
?>