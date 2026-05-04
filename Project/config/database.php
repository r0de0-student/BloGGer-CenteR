<?php
// Поддержка как Docker, так и XAMPP
// В Docker переменные окружения задаются в docker-compose.yml
// В XAMPP используется localhost

$host = getenv('DB_HOST') ?: 'localhost';
$dbname = getenv('DB_NAME') ?: 'blogger_center';
$user = getenv('DB_USER') ?: 'root';
$pass = getenv('DB_PASS') ?: '';  // В XAMPP пароль пустой, в Docker 'root'

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
    die("❌ Ошибка подключения: " . $e->getMessage());
}
?>