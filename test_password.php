<?php
require_once 'config/database.php';
require_once 'models/User.php';

$userModel = new User($pdo);
$user = $userModel->findByEmail('admin@blog.com');

echo "<h1>Тест пароля</h1>";
echo "<p>Email: admin@blog.com</p>";
echo "<p>Хэш в БД: " . $user['password'] . "</p>";

$testPassword = 'password';
echo "<p>Проверка пароля '{$testPassword}': " . (password_verify($testPassword, $user['password']) ? '✅ ВЕРНО' : '❌ НЕВЕРНО') . "</p>";

// Создаём новый корректный хэш
$newHash = password_hash('password', PASSWORD_BCRYPT);
echo "<p>Новый корректный хэш: {$newHash}</p>";
echo "<p>Скопируйте этот хэш и выполните SQL:</p>";
echo "<code>UPDATE users SET password = '{$newHash}' WHERE email = 'admin@blog.com';</code>";
?>