CREATE DATABASE IF NOT EXISTS blogger_center;
USE blogger_center;

CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'root';
GRANT ALL PRIVILEGES ON blogger_center.* TO 'root'@'%';
FLUSH PRIVILEGES;

CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'author',
    is_blocked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    views_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE
);

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
);

CREATE TABLE IF NOT EXISTS subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subscriber_id INT NOT NULL,
    blog_id INT NOT NULL,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subscriber_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE,
    UNIQUE KEY unique_subscription (subscriber_id, blog_id)
);


INSERT INTO users (id, name, email, password, role, is_blocked) VALUES
(1, 'Admin', 'admin@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 0),
(2, 'John Author', 'john@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author', 0),
(5, 'Иван', 'ivan22@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author', 0),
(6, 'Andrey', 'ADR@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author', 0);

-- Блоги
INSERT INTO blogs (id, user_id, name, description) VALUES
(1, 2, 'Блог Джона', 'Истории из жизни программиста'),
(2, 5, 'Блог Ивана', 'Мои мысли и идеи'),
(3, 6, 'Блог Андрея', 'Технологии и разработка');

-- Статьи
INSERT INTO posts (id, blog_id, title, content, views_count) VALUES
(1, 1, 'Первая статья', 'Привет мир! Это моя первая статья в блоге.', 9),
(2, 1, 'Как начать программировать', 'Советы для начинающих: выберите язык, практикуйтесь каждый день.', 9),
(3, 1, 'Привет всем', 'немного о себе ого...', 18),
(4, 1, 'Я работаю над проектом', 'Всем привет, новый пост о моем проекте...', 29),
(5, 2, 'Мой первый пост', 'Привет всем! Это моя первая статья.', 5),
(6, 3, 'Docker для начинающих', 'Расскажу как настроить Docker и запустить проект.', 12);

-- Комментарии
INSERT INTO comments (id, post_id, user_id, content, is_deleted) VALUES
(1, 1, 2, 'Отличная статья! Жду продолжения.', 0),
(2, 1, 5, 'Спасибо за поддержку!', 0),
(3, 3, 2, 'ого как круто', 0),
(4, 4, 5, 'Интересно, расскажи подробнее!', 0),
(5, 4, 1, 'Хорошая работа!', 0),
(6, 6, 2, 'Полезная статья, спасибо!', 0);