<!DOCTYPE html>
<html>
<head>
    <title>BloGGing CenteR</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial; background: #f5f5f5; }
        nav { background: #333; color: white; padding: 15px; }
        nav a { color: white; text-decoration: none; margin-right: 20px; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; }
        .btn { display: inline-block; padding: 8px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; }
        .btn-success { background: #28a745; }
        .btn-danger { background: #dc3545; }
        .alert-error { background: #f8d7da; color: #721c24; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .alert-success { background: #d4edda; color: #155724; padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .post-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f0f0f0; }
        input, textarea { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; }
        button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        .comment { border-left: 3px solid #007bff; padding-left: 15px; margin-bottom: 15px; }
    </style>
</head>
<body>
    <nav>
        <a href="<?= BASE_PATH ?>/?action=home">🏠 Главная</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?= BASE_PATH ?>/?action=my-blog">📝 Мой блог</a>
            <a href="<?= BASE_PATH ?>/?action=all-blogs">📚 Все блоги</a>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="<?= BASE_PATH ?>/?action=admin-users">👑 Админка</a>
            <?php endif; ?>
            <a href="<?= BASE_PATH ?>/?action=logout" style="float: right;">🚪 Выйти (<?= htmlspecialchars($_SESSION['user_name']) ?>)</a>
        <?php else: ?>
            <a href="<?= BASE_PATH ?>/?action=login" style="float: right;">🔐 Вход</a>
            <a href="<?= BASE_PATH ?>/?action=register" style="float: right; margin-right: 20px;">📝 Регистрация</a>
        <?php endif; ?>
    </nav>
    <div class="container">