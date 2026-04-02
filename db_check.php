<?php
echo "<h1>Проверка MySQL в OpenServer</h1>";

// Проверяем разные варианты подключения
$ports = [3306, 3307, 3308];
$connected = false;

foreach ($ports as $port) {
    echo "<p>Пробуем порт $port... ";
    try {
        $test = new PDO("mysql:host=localhost;port=$port", "root", "");
        echo "✅ УСПЕХ! MySQL работает на порту $port</p>";
        $connected = true;
        break;
    } catch(PDOException $e) {
        echo "❌ Ошибка: " . $e->getMessage() . "</p>";
    }
}

if (!$connected) {
    echo "<p style='color:red'>⚠️ MySQL не запущен или работает на другом порту</p>";
    echo "<p>👉 Откройте OpenServer → Настройки → Порты → Посмотрите порт MySQL</p>";
}
?>