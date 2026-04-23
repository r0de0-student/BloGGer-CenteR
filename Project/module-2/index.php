<?php
session_start();
define('BASE_PATH', '/blogger-center');

require_once __DIR__ . '/config/database.php';
require_once __DIR__ . '/config/auth.php';
require_once __DIR__ . '/models/User.php';
require_once __DIR__ . '/models/Blog.php';
require_once __DIR__ . '/models/Post.php';
require_once __DIR__ . '/models/Comment.php';
require_once __DIR__ . '/models/Subscription.php';
require_once __DIR__ . '/vendor/autoload.php';

require_once __DIR__ . '/controllers/HomeController.php';
require_once __DIR__ . '/controllers/AuthController.php';
require_once __DIR__ . '/controllers/PostController.php';
require_once __DIR__ . '/controllers/BlogController.php';
require_once __DIR__ . '/controllers/AdminController.php';
require_once __DIR__ . '/controllers/ReportController.php';
require_once __DIR__ . '/controllers/ExportController.php';

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
        // Reports
    case 'reports':
        $controller = new ReportController($pdo);
        $controller->index();
        break;
    case 'report-users':
        $controller = new ReportController($pdo);
        $controller->users();
        break;
    case 'report-posts':
        $controller = new ReportController($pdo);
        $controller->posts();
        break;
    case 'report-top-blogs':
        $controller = new ReportController($pdo);
        $controller->topBlogs();
        break;
    case 'author-stats':
        $controller = new ReportController($pdo);
        $controller->authorStats();
        break;
    case 'access-denied':
        require_once __DIR__ . '/views/error/access-denied.php';
        break;
        // Export
    case 'export-users-excel':
        $controller = new ExportController($pdo);
        $controller->usersToExcel();
        break;
    case 'export-users-word':
        $controller = new ExportController($pdo);
        $controller->usersToWord();
        break;
    case 'export-posts-excel':
        $controller = new ExportController($pdo);
        $controller->postsToExcel();
        break;
    case 'export-posts-word':
        $controller = new ExportController($pdo);
        $controller->postsToWord();
        break;
    case 'export-top-blogs-excel':
        $controller = new ExportController($pdo);
        $controller->topBlogsToExcel();
        break;
    case 'export-top-blogs-word':
        $controller = new ExportController($pdo);
        $controller->topBlogsToWord();
        break;
    default:
        header('Location: ' . BASE_PATH . '/?action=home');
        break;
}
?>