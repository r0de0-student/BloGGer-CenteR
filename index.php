<?php
session_start();
define('BASE_PATH', '/blogger-center');

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Blog.php';
require_once __DIR__ . '/models/Post.php';
require_once __DIR__ . '/models/Comment.php';
require_once __DIR__ . '/models/Subscription.php';

require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/PostController.php';
require_once __DIR__ . '/controllers/BlogController.php';
require_once __DIR__ . '/controllers/AdminController.php';

$action = $_GET['action'] ?? 'home';

switch ($action) {
    case 'home':
        $controller = new HomeController($pdo);
        $controller->index();
        break;
    case 'login':
        $controller = new AuthController($pdo);
        $controller->loginForm();
        break;
    case 'do-login':
        $controller = new AuthController($pdo);
        $controller->login();
        break;
    case 'register':
        $controller = new AuthController($pdo);
        $controller->registerForm();
        break;
    case 'do-register':
        $controller = new AuthController($pdo);
        $controller->register();
        break;
    case 'logout':
        $controller = new AuthController($pdo);
        $controller->logout();
        break;
    case 'view-post':
        $controller = new PostController($pdo);
        $controller->view($_GET['id']);
        break;
    case 'create-post':
        $controller = new PostController($pdo);
        $controller->createForm();
        break;
    case 'do-create-post':
        $controller = new PostController($pdo);
        $controller->create();
        break;
    case 'edit-post':
        $controller = new PostController($pdo);
        $controller->editForm($_GET['id']);
        break;
    case 'do-update-post':
        $controller = new PostController($pdo);
        $controller->update($_GET['id']);
        break;
    case 'delete-post':
        $controller = new PostController($pdo);
        $controller->delete($_GET['id']);
        break;
    case 'add-comment':
        $controller = new PostController($pdo);
        $controller->addComment($_GET['id']);
        break;
    case 'my-blog':
        $controller = new BlogController($pdo);
        $controller->myBlog();
        break;
    case 'create-blog':
        $controller = new BlogController($pdo);
        $controller->createForm();
        break;
    case 'do-create-blog':
        $controller = new BlogController($pdo);
        $controller->create();
        break;
    case 'edit-blog':
        $controller = new BlogController($pdo);
        $controller->editForm();
        break;
    case 'do-update-blog':
        $controller = new BlogController($pdo);
        $controller->update();
        break;
    case 'all-blogs':
        $controller = new BlogController($pdo);
        $controller->allBlogs();
        break;
    case 'admin-users':
        $controller = new AdminController($pdo);
        $controller->users();
        break;
    case 'toggle-block':
        $controller = new AdminController($pdo);
        $controller->toggleBlock($_GET['id']);
        break;
    default:
        header('Location: ' . BASE_PATH . '/?action=home');
        break;
}
?>