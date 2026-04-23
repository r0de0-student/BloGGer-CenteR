<!DOCTYPE html>
<html>
<head>
    <title>BloGGing CenteR</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; background: #f5f5f5; }
        nav { background: #333; color: white; padding: 15px; overflow: hidden; }
        nav a { color: white; text-decoration: none; margin-right: 20px; }
        nav a:hover { text-decoration: underline; }
        nav .float-right { float: right; }
        .container { max-width: 1200px; margin: 20px auto; padding: 20px; background: white; border-radius: 10px; min-height: 500px; }
        h1 { margin-bottom: 20px; color: #333; }
        .post-card { border: 1px solid #ddd; padding: 15px; margin-bottom: 15px; border-radius: 8px; background: white; }
        .post-card h3 { margin-bottom: 10px; color: #007bff; }
        .btn { display: inline-block; padding: 8px 15px; background: #007bff; color: white; text-decoration: none; border-radius: 5px; border: none; cursor: pointer; font-size: 14px; }
        .btn:hover { opacity: 0.8; }
        .btn-danger { background: #dc3545; }
        .btn-success { background: #28a745; }
        .btn-warning { background: #ffc107; color: #333; }
        form input, form textarea, form select { width: 100%; padding: 10px; margin-bottom: 10px; border: 1px solid #ddd; border-radius: 5px; }
        form button { padding: 10px 20px; background: #007bff; color: white; border: none; border-radius: 5px; cursor: pointer; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f0f0f0; }
        .alert-error {
            background: linear-gradient(135deg, #f8d7da 0%, #f1b0b7 100%);
            color: #721c24;
            border: 2px solid #f5c6cb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        .alert-success {
            background: linear-gradient(135deg, #d4edda 0%, #a3dfb0 100%);
            color: #155724;
            border: 2px solid #c3e6cb;
            border-radius: 12px;
            padding: 20px;
            margin-bottom: 25px;
            text-align: center;
            font-size: 18px;
            font-weight: bold;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        }

        input:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        button {
            transition: transform 0.2s, opacity 0.2s;
        }

        button:hover {
            transform: translateY(-2px);
            opacity: 0.9;
        }

        button:active {
            transform: translateY(0);
        }
        .alert { padding: 10px; margin-bottom: 20px; border-radius: 5px; }
        .alert-error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .alert-success { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .comment { border-left: 3px solid #007bff; padding-left: 15px; margin-bottom: 15px; }
        footer { text-align: center; padding: 20px; color: #666; font-size: 12px; border-top: 1px solid #ddd; margin-top: 30px; }
    </style>
</head>
<body>
    <nav>
        <a href="<?= BASE_PATH ?>/?action=home">🏠 Главная</a>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="<?= BASE_PATH ?>/?action=my-blog">📝 Мой блог</a>
            <a href="<?= BASE_PATH ?>/?action=reports">📊 Отчёты</a>
            <?php if ($_SESSION['role'] == 'admin'): ?>
                <a href="<?= BASE_PATH ?>/?action=admin-users">👑 Админка</a>
            <?php endif; ?>
            <a href="<?= BASE_PATH ?>/?action=logout" class="float-right">🚪 Выйти (<?= htmlspecialchars($_SESSION['user_name']) ?>)</a>
        <?php else: ?>
            <a href="<?= BASE_PATH ?>/?action=login" class="float-right">🔐 Вход</a>
            <a href="<?= BASE_PATH ?>/?action=register" class="float-right" style="margin-right: 20px;">📝 Регистрация</a>
        <?php endif; ?>
    </nav>
    
    <div class="container">