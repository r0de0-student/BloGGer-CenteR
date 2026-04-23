<?php
/**
 * Файл аутентификации и авторизации
 * Функции для проверки прав доступа пользователей
 */

/**
 * Проверка, авторизован ли пользователь
 * @return bool
 */
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

/**
 * Проверка, является ли пользователь администратором
 * @return bool
 */
function isAdmin() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
}

/**
 * Проверка, является ли пользователь автором
 * @return bool
 */
function isAuthor() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']) && ($_SESSION['role'] === 'author' || $_SESSION['role'] === 'admin');
}

/**
 * Проверка, является ли пользователь читателем
 * @return bool
 */
function isReader() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role']) && $_SESSION['role'] === 'reader';
}

/**
 * Получить текущую роль пользователя
 * @return string|null
 */
function getCurrentRole() {
    return isset($_SESSION['role']) ? $_SESSION['role'] : null;
}

/**
 * Получить ID текущего пользователя
 * @return int|null
 */
function getCurrentUserId() {
    return isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;
}

/**
 * Получить имя текущего пользователя
 * @return string|null
 */
function getCurrentUserName() {
    return isset($_SESSION['user_name']) ? $_SESSION['user_name'] : null;
}

/**
 * Требовать авторизацию (если не авторизован -> редирект на логин)
 */
function requireLogin() {
    if (!isLoggedIn()) {
        $_SESSION['error'] = "⚠️ Для доступа к этой странице необходимо войти в систему";
        header('Location: ' . BASE_PATH . '/?action=login');
        exit;
    }
}

/**
 * Требовать роль администратора
 */
function requireAdmin() {
    requireLogin();
    if (!isAdmin()) {
        $_SESSION['error'] = "⛔ У вас нет прав доступа к этой странице. Требуются права администратора.";
        header('Location: ' . BASE_PATH . '/?action=access-denied');
        exit;
    }
}

/**
 * Требовать роль автора
 */
function requireAuthor() {
    requireLogin();
    if (!isAuthor()) {
        $_SESSION['error'] = "✍️ У вас нет прав доступа к этой странице. Требуются права автора.";
        header('Location: ' . BASE_PATH . '/?action=access-denied');
        exit;
    }
}

/**
 * Требовать роль читателя
 */
function requireReader() {
    requireLogin();
    if (!isReader()) {
        $_SESSION['error'] = "📖 У вас нет прав доступа к этой странице. Требуются права читателя.";
        header('Location: ' . BASE_PATH . '/?action=access-denied');
        exit;
    }
}

/**
 * Проверить, имеет ли пользователь доступ к ресурсу
 * @param string $requiredRole - требуемая роль (admin, author, reader)
 * @return bool
 */
function hasAccess($requiredRole) {
    if (!isLoggedIn()) return false;
    
    switch ($requiredRole) {
        case 'admin':
            return isAdmin();
        case 'author':
            return isAuthor();
        case 'reader':
            return isReader();
        default:
            return false;
    }
}

/**
 * Перенаправить на страницу входа с сообщением
 * @param string $message - сообщение об ошибке
 */
function redirectToLogin($message = "Пожалуйста, войдите в систему") {
    $_SESSION['error'] = $message;
    header('Location: ' . BASE_PATH . '/?action=login');
    exit;
}

/**
 * Перенаправить на главную с сообщением об ошибке доступа
 * @param string $message - сообщение об ошибке
 */
function redirectToHomeWithError($message = "У вас нет прав доступа") {
    $_SESSION['error'] = $message;
    header('Location: ' . BASE_PATH . '/?action=home');
    exit;
}

/**
 * Перенаправить на страницу ошибки доступа
 * @param string $message - сообщение об ошибке
 */
function redirectToAccessDenied($message = "У вас нет прав доступа к этой странице") {
    $_SESSION['error'] = $message;
    header('Location: ' . BASE_PATH . '/?action=access-denied');
    exit;
}

/**
 * Проверить, что пользователь является владельцем ресурса
 * @param int $userId - ID владельца ресурса
 * @return bool
 */
function isOwner($userId) {
    return isLoggedIn() && getCurrentUserId() == $userId;
}

/**
 * Проверить, что пользователь является владельцем ресурса или администратором
 * @param int $userId - ID владельца ресурса
 * @return bool
 */
function canEdit($userId) {
    return isLoggedIn() && (isAdmin() || isOwner($userId));
}

/**
 * Выход из системы
 */
function logout() {
    $_SESSION = array();
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), '', time()-3600, '/');
    }
    session_destroy();
    header('Location: ' . BASE_PATH . '/?action=home');
    exit;
}

/**
 * Проверка на заблокированного пользователя
 * @param object $userModel - модель пользователя
 * @param int $userId - ID пользователя
 * @return bool
 */
function isBlocked($userModel, $userId) {
    $user = $userModel->findById($userId);
    return $user && $user['is_blocked'] == 1;
}
?>