-- ============================================
-- Создание базы данных с UTF-8
-- ============================================
CREATE DATABASE IF NOT EXISTS blogger_center CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blogger_center;

-- Пользователь
CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'root';
GRANT ALL PRIVILEGES ON blogger_center.* TO 'root'@'%';
FLUSH PRIVILEGES;

-- Таблица users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name NVARCHAR(100) NOT NULL,
    email NVARCHAR(255) UNIQUE NOT NULL,
    password NVARCHAR(255) NOT NULL,
    role NVARCHAR(50) DEFAULT 'author',
    is_blocked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Таблица blogs
CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name NVARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Таблица posts
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    title NVARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    views_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Таблица comments
CREATE TABLE IF NOT EXISTS comments (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    user_id INT NOT NULL,
    content TEXT NOT NULL,
    parent_comment_id INT NULL,
    is_deleted BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Пользователи (пароль = 'password')
INSERT INTO users (id, name, email, password, role, is_blocked) VALUES
(1, 'Admin', 'admin@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 0),
(2, 'John Author', 'john@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author', 0),
(5, 'Иван', 'ivan22@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author', 0),
(6, 'Андрей', 'andr@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author', 0);

-- Блоги
INSERT INTO blogs (id, user_id, name, description) VALUES
(1, 2, 'Блог Джона', 'Истории из жизни программиста'),
(2, 5, 'Блог Ивана', 'Мои мысли и идеи'),
(3, 6, 'Блог Андрея', 'Технологии и разработка');

-- Статьи
INSERT INTO posts (id, blog_id, title, content, views_count) VALUES
(1, 1, 'Первая статья', 'Привет мир! Это моя первая статья в блоге.', 19),
(2, 1, 'Как начать программировать', 'Советы для начинающих: выберите язык, практикуйтесь каждый день.', 18),
(3, 1, 'Привет всем', 'Немного о себе...', 18),
(4, 1, 'Я работаю над проектом', 'Всем привет, новый пост о моем проекте...', 29);

-- Комментарии
INSERT INTO comments (id, post_id, user_id, content, is_deleted) VALUES
(1, 1, 2, 'Отличная статья! Жду продолжения.', 0),
(2, 1, 5, 'Спасибо за поддержку!', 0),
(3, 3, 2, 'Ого как круто', 0);