-- Установка кодировки
SET NAMES utf8mb4;
SET CHARACTER SET utf8mb4;

CREATE DATABASE IF NOT EXISTS blogger_center CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE blogger_center;

CREATE USER IF NOT EXISTS 'root'@'%' IDENTIFIED BY 'root';
GRANT ALL PRIVILEGES ON blogger_center.* TO 'root'@'%';
FLUSH PRIVILEGES;

-- Таблица users
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(255) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    role VARCHAR(50) DEFAULT 'author',
    is_blocked BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица blogs
CREATE TABLE IF NOT EXISTS blogs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица posts
CREATE TABLE IF NOT EXISTS posts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    blog_id INT NOT NULL,
    title VARCHAR(255) NOT NULL,
    content LONGTEXT NOT NULL,
    views_count INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

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
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Таблица subscriptions
CREATE TABLE IF NOT EXISTS subscriptions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    subscriber_id INT NOT NULL,
    blog_id INT NOT NULL,
    subscribed_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (subscriber_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (blog_id) REFERENCES blogs(id) ON DELETE CASCADE,
    UNIQUE KEY unique_subscription (subscriber_id, blog_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- =====================================================
-- ТЕСТОВЫЕ ДАННЫЕ
-- =====================================================

INSERT INTO users (id, name, email, password, role, is_blocked) VALUES
(1, 'Admin', 'admin@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 0),
(2, 'John Author', 'john@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author', 0),
(3, 'Иван', 'ivan22@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author', 0),
(4, 'Андрей', 'andr@blog.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'author', 0);

INSERT INTO blogs (id, user_id, name, description) VALUES
(1, 2, 'Блог Джона', 'Истории из жизни программиста'),
(2, 3, 'Блог Ивана', 'Мои мысли и идеи'),
(3, 4, 'Блог Андрея', 'Технологии и разработка');

INSERT INTO posts (id, blog_id, title, content, views_count) VALUES
(1, 1, 'Как я изучаю программирование', 'Каждый день я учу что-то новое. Сейчас осваиваю Docker и готовлю проект к деплою.', 24),
(2, 1, 'Почему PHP до сих пор актуален', 'PHP используется на 75% сайтов в интернете.', 18),
(3, 1, 'Мой первый пост', 'Привет мир! Это моя первая статья.', 29),
(4, 2, 'Мой опыт в IT', 'Расскажу как я начал программировать...', 15),
(5, 3, 'Docker для начинающих', 'Пошаговое руководство по Docker.', 10);

INSERT INTO comments (id, post_id, user_id, content, is_deleted) VALUES
(1, 1, 1, 'Отличная статья! Продолжай в том же духе.', 0),
(2, 1, 2, 'Спасибо за поддержку!', 0),
(3, 2, 1, 'PHP действительно актуален, согласен.', 0),
(4, 3, 3, 'Привет! Отличный блог!', 0);

INSERT INTO subscriptions (subscriber_id, blog_id) VALUES
(3, 1),
(4, 1),
(1, 2);