<?php
session_start();
require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Blog.php';
require_once __DIR__ . '/models/Post.php';
require_once __DIR__ . '/models/Comment.php';
require_once __DIR__ . '/models/Subscription.php';

$userModel = new User($pdo);
$blogModel = new Blog($pdo);
$postModel = new Post($pdo);
$commentModel = new Comment($pdo);
$subscriptionModel = new Subscription($pdo);

$action = $_GET['action'] ?? 'home';
?>

<!DOCTYPE html>
<html>
<head>
    <title>BloGGing CenteR</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        nav { background: #333; color: white; padding: 15px; }
        nav a { color: white; text-decoration: none; margin-right: 20px; }
        nav a:hover { text-decoration: underline; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; }
        h1 { margin-bottom: 20px; color: #333; }
        .post-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; }
        .post-card h3 { margin-bottom: 10px; }
        .btn { display: inline-block; padding: 8px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; margin-top: 10px; }
        .btn-danger { background: #dc3545; }
        .btn-success { background: #28a745; }
        form input, form textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; }
        form button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f0f0f0; }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
    </style>
</head>
<body>
    <nav>
        <a href="?action=home">🏠 Главная</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="?action=my-blog">📝 Мой блог</a>
            <a href="?action=blogs">📚 Все блоги</a>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="?action=admin-users">👑 Админка</a>
            <?php endif; ?>
            <a href="?action=logout" style="float: right;">🚪 Выйти (<?= htmlspecialchars($_SESSION['user_name']) ?>)</a>
        <?php else: ?>
            <a href="?action=login" style="float: right;">🔐 Вход</a>
            <a href="?action=register" style="float: right; margin-right: 20px;">📝 Регистрация</a>
        <?php endif; ?>
    </nav>
    
    <div class="container">
        <?php
        // Роутинг
        switch($action) {
            case 'home':
                $posts = $postModel->getAll();
                ?>
                <h1>📖 Все статьи</h1>
                <?php if (empty($posts)): ?>
                    <p>Пока нет статей. Станьте автором и создайте первую!</p>
                <?php else: ?>
                    <?php foreach($posts as $post): ?>
                        <div class="post-card">
                            <h3><?= htmlspecialchars($post['title']) ?></h3>
                            <p><small>📝 Автор: <?= htmlspecialchars($post['author_name']) ?> | 👁️ Просмотров: <?= $post['views_count'] ?> | 📅 <?= $post['created_at'] ?></small></p>
                            <p><?= htmlspecialchars(mb_substr($post['content'], 0, 200)) ?>...</p>
                            <a href="?action=view-post&id=<?= $post['id'] ?>" class="btn">Читать далее →</a>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
                <?php
                break;
                
            case 'login':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $user = $userModel->findByEmail($_POST['email']);
                    if ($user && password_verify($_POST['password'], $user['password'])) {
                        if ($user['is_blocked']) {
                            $error = "Ваш аккаунт заблокирован!";
                        } else {
                            $_SESSION['user_id'] = $user['id'];
                            $_SESSION['user_name'] = $user['name'];
                            $_SESSION['role'] = $user['role'];
                            header('Location: ?action=home');
                            exit;
                        }
                    } else {
                        $error = "Неверный email или пароль!";
                    }
                }
                ?>
                <h1>🔐 Вход в систему</h1>
                <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Пароль" required>
                    <button type="submit">Войти</button>
                </form>
                <p style="margin-top: 15px;">Нет аккаунта? <a href="?action=register">Зарегистрироваться</a></p>
                <p style="margin-top: 10px; font-size: 12px; color: gray;">Тестовые: admin@blog.com / password | john@blog.com / password | mike@blog.com / password</p>
                <?php
                break;
                
            case 'register':
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $name = trim($_POST['name']);
                    $email = trim($_POST['email']);
                    $password = $_POST['password'];
                    
                    if (empty($name) || empty($email) || empty($password)) {
                        $error = "Все поля обязательны!";
                    } elseif (strlen($password) < 6) {
                        $error = "Пароль должен быть не менее 6 символов!";
                    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                        $error = "Неверный формат email!";
                    } else {
                        if ($userModel->create($name, $email, $password)) {
                            header('Location: ?action=login');
                            exit;
                        } else {
                            $error = "Email уже зарегистрирован!";
                        }
                    }
                }
                ?>
                <h1>📝 Регистрация</h1>
                <?php if (isset($error)): ?>
                    <div class="alert alert-error"><?= htmlspecialchars($error) ?></div>
                <?php endif; ?>
                <form method="POST">
                    <input type="text" name="name" placeholder="Имя" required>
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Пароль (мин. 6 символов)" required>
                    <button type="submit">Зарегистрироваться</button>
                </form>
                <p style="margin-top: 15px;">Уже есть аккаунт? <a href="?action=login">Войти</a></p>
                <?php
                break;
                
            case 'logout':
                session_destroy();
                header('Location: ?action=home');
                exit;
                break;
                
            case 'my-blog':
                if (!isset($_SESSION['user_id'])) {
                    header('Location: ?action=login');
                    exit;
                }
                $blog = $blogModel->findByUserId($_SESSION['user_id']);
                if (!$blog) {
                    ?>
                    <h1>📝 Создать блог</h1>
                    <form method="POST" action="?action=create-blog">
                        <input type="text" name="name" placeholder="Название блога" required>
                        <textarea name="description" placeholder="Описание блога" rows="3"></textarea>
                        <button type="submit">Создать блог</button>
                    </form>
                    <?php
                } else {
                    $posts = $postModel->getByBlogId($blog['id']);
                    ?>
                    <h1>📝 <?= htmlspecialchars($blog['name']) ?></h1>
                    <p><?= htmlspecialchars($blog['description']) ?></p>
                    <a href="?action=edit-blog" class="btn">✏️ Редактировать блог</a>
                    <a href="?action=create-post" class="btn btn-success">➕ Новая статья</a>
                    
                    <h2 style="margin-top: 30px;">Мои статьи</h2>
                    <?php if (empty($posts)): ?>
                        <p>У вас пока нет статей. Создайте первую!</p>
                    <?php else: ?>
                        <table>
                            <tr><th>Заголовок</th><th>Просмотры</th><th>Дата</th><th>Действия</th></tr>
                            <?php foreach($posts as $post): ?>
                            <tr>
                                <td><?= htmlspecialchars($post['title']) ?></td>
                                <td><?= $post['views_count'] ?></td>
                                <td><?= $post['created_at'] ?></td>
                                <td>
                                    <a href="?action=edit-post&id=<?= $post['id'] ?>">✏️</a>
                                    <a href="?action=delete-post&id=<?= $post['id'] ?>" onclick="return confirm('Удалить статью?')">❌</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    <?php endif; ?>
                    <?php
                }
                break;
                
            case 'create-blog':
                if (!isset($_SESSION['user_id'])) {
                    header('Location: ?action=login');
                    exit;
                }
                $blogModel->create($_SESSION['user_id'], $_POST['name'], $_POST['description']);
                header('Location: ?action=my-blog');
                break;
                
            case 'edit-blog':
                if (!isset($_SESSION['user_id'])) {
                    header('Location: ?action=login');
                    exit;
                }
                $blog = $blogModel->findByUserId($_SESSION['user_id']);
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $blogModel->update($blog['id'], $_POST['name'], $_POST['description']);
                    header('Location: ?action=my-blog');
                    exit;
                }
                ?>
                <h1>✏️ Редактировать блог</h1>
                <form method="POST">
                    <input type="text" name="name" value="<?= htmlspecialchars($blog['name']) ?>" required>
                    <textarea name="description" rows="3"><?= htmlspecialchars($blog['description']) ?></textarea>
                    <button type="submit">Сохранить</button>
                </form>
                <?php
                break;
                
            case 'create-post':
                if (!isset($_SESSION['user_id'])) {
                    header('Location: ?action=login');
                    exit;
                }
                $blog = $blogModel->findByUserId($_SESSION['user_id']);
                if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                    $postModel->create($blog['id'], $_POST['title'], $_POST['content']);
                    header('Location: ?action=my-blog');
                    exit;
                }
                ?>
                <h1>➕ Новая статья</h1>
                <form method="POST">
                    <input type="text" name="title" placeholder="Заголовок" required>
                    <textarea name="content" placeholder="Текст статьи" rows="10" required></textarea>
                    <button type="submit">Опубликовать</button>
                </form>
                <?php
                break;
                
            case 'view-post':
                $id = $_GET['id'];
                $postModel->incrementViews($id);
                $post = $postModel->getById($id);
                $comments = $commentModel->getByPostId($id);
                ?>
                <h1><?= htmlspecialchars($post['title']) ?></h1>
                <p><small>📝 Блог: <?= htmlspecialchars($post['blog_name']) ?> | Автор: <?= htmlspecialchars($post['author_name']) ?> | 👁️ <?= $post['views_count'] ?> просмотров</small></p>
                <div style="margin: 20px 0; line-height: 1.6;"><?= nl2br(htmlspecialchars($post['content'])) ?></div>
                
                <h3>💬 Комментарии (<?= count($comments) ?>)</h3>
                <?php if (isset($_SESSION['user_id'])): ?>
                    <form method="POST" style="margin-bottom: 20px;">
                        <textarea name="content" placeholder="Написать комментарий..." rows="3" required></textarea>
                        <button type="submit" name="add-comment">Отправить</button>
                    </form>
                <?php else: ?>
                    <p><a href="?action=login">Войдите</a>, чтобы оставить комментарий</p>
                <?php endif; ?>
                
                <?php if (isset($_POST['add-comment']) && isset($_SESSION['user_id'])): ?>
                    <?php 
                    $commentModel->create($id, $_SESSION['user_id'], $_POST['content']);
                    header("Location: ?action=view-post&id=$id");
                    exit;
                    ?>
                <?php endif; ?>
                
                <?php foreach($comments as $comment): ?>
                    <div style="border-left: 3px solid #007bff; padding-left: 15px; margin-bottom: 15px;">
                        <strong><?= htmlspecialchars($comment['user_name']) ?></strong> 
                        <small><?= $comment['created_at'] ?></small>
                        <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
                    </div>
                <?php endforeach; ?>
                <?php
                break;
                
            case 'admin-users':
                if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
                    header('Location: ?action=home');
                    exit;
                }
                $users = $userModel->getAll();
                ?>
                <h1>👑 Управление пользователями</h1>
                <table>
                    <tr><th>ID</th><th>Имя</th><th>Email</th><th>Роль</th><th>Статус</th><th>Действия</th></tr>
                    <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user['id'] ?></td>
                        <td><?= htmlspecialchars($user['name']) ?></td>
                        <td><?= htmlspecialchars($user['email']) ?></td>
                        <td><?= $user['role'] ?></td>
                        <td><?= $user['is_blocked'] ? '🔒 Заблокирован' : '✅ Активен' ?></td>
                        <td>
                            <a href="?action=toggle-block&id=<?= $user['id'] ?>" onclick="return confirm('Изменить статус?')">
                                <?= $user['is_blocked'] ? '🔓 Разблокировать' : '🔒 Заблокировать' ?>
                            </a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </table>
                <?php
                break;
                
            case 'toggle-block':
                if (!isset($_SESSION['user_id']) || $_SESSION['role'] != 'admin') {
                    header('Location: ?action=home');
                    exit;
                }
                $userModel->toggleBlock($_GET['id']);
                header('Location: ?action=admin-users');
                break;
                
            case 'delete-post':
                if (!isset($_SESSION['user_id'])) {
                    header('Location: ?action=login');
                    exit;
                }
                $postModel->delete($_GET['id']);
                header('Location: ?action=my-blog');
                break;
                
            default:
                header('Location: ?action=home');
                break;
        }
        ?>
    </div>
</body>
</html>