<?php
class User {
    private $db;
    
    public function __construct($pdo) {
        $this->db = $pdo;
    }
    
    /**
     * Найти пользователя по email
     */
    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch();
    }
    
    /**
     * Найти пользователя по ID
     */
    public function findById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }
    
    /**
     * Создать нового пользователя (по умолчанию роль 'author')
     */
    public function create($name, $email, $password) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, 'author')");
        return $stmt->execute([$name, $email, $hashed]);
    }
    
    /**
     * Создать пользователя с указанием роли (для админа)
     */
    public function createWithRole($name, $email, $password, $role) {
        $hashed = password_hash($password, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$name, $email, $hashed, $role]);
    }
    
    /**
     * Получить всех пользователей (для админ-панели)
     */
    public function getAll() {
        $stmt = $this->db->query("SELECT * FROM users ORDER BY created_at DESC");
        return $stmt->fetchAll();
    }
    
    /**
     * Заблокировать / разблокировать пользователя
     */
    public function toggleBlock($userId) {
        $stmt = $this->db->prepare("UPDATE users SET is_blocked = NOT is_blocked WHERE id = ?");
        return $stmt->execute([$userId]);
    }
    
    /**
     * Обновить роль пользователя
     */
    public function updateRole($userId, $role) {
        $stmt = $this->db->prepare("UPDATE users SET role = ? WHERE id = ?");
        return $stmt->execute([$role, $userId]);
    }
    
    /**
     * Повысить читателя до автора
     */
    public function upgradeToAuthor($userId) {
        $stmt = $this->db->prepare("UPDATE users SET role = 'author' WHERE id = ? AND role = 'reader'");
        return $stmt->execute([$userId]);
    }
    
    /**
     * Получить количество зарегистрированных пользователей
     */
    public function getCount() {
        $stmt = $this->db->query("SELECT COUNT(*) as count FROM users");
        return $stmt->fetch()['count'];
    }
    
    /**
     * Получить всех авторов (пользователи с ролью author)
     */
    public function getAllAuthors() {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE role = 'author' ORDER BY created_at DESC");
        $stmt->execute();
        return $stmt->fetchAll();
    }
    
    /**
     * Проверить, является ли пользователь администратором
     */
    public function isAdmin($userId) {
        $stmt = $this->db->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        return $user && $user['role'] === 'admin';
    }
    
    /**
     * Проверить, является ли пользователь автором
     */
    public function isAuthor($userId) {
        $stmt = $this->db->prepare("SELECT role FROM users WHERE id = ?");
        $stmt->execute([$userId]);
        $user = $stmt->fetch();
        return $user && ($user['role'] === 'author' || $user['role'] === 'admin');
    }
    
    /**
     * Обновить профиль пользователя
     */
    public function updateProfile($userId, $name, $email) {
        $stmt = $this->db->prepare("UPDATE users SET name = ?, email = ? WHERE id = ?");
        return $stmt->execute([$name, $email, $userId]);
    }
    
    /**
     * Сменить пароль пользователя
     */
    public function updatePassword($userId, $newPassword) {
        $hashed = password_hash($newPassword, PASSWORD_BCRYPT);
        $stmt = $this->db->prepare("UPDATE users SET password = ? WHERE id = ?");
        return $stmt->execute([$hashed, $userId]);
    }
    
    /**
     * Удалить пользователя (только для админа)
     */
    public function delete($userId) {
        // Сначала удаляем связанные данные (блоги, статьи, комментарии)
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$userId]);
    }
    
    /**
     * Поиск пользователей по имени или email
     */
    public function search($query) {
        $stmt = $this->db->prepare("
            SELECT * FROM users 
            WHERE name LIKE ? OR email LIKE ? 
            ORDER BY created_at DESC
        ");
        $searchTerm = "%$query%";
        $stmt->execute([$searchTerm, $searchTerm]);
        return $stmt->fetchAll();
    }
}
?>