<?php 
// Если есть сессия, получаем ошибку
$error_message = isset($_SESSION['error']) ? $_SESSION['error'] : "У вас нет прав доступа к этой странице.";
unset($_SESSION['error']);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Доступ запрещён - BloGGing CenteR</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #ffffff 0%, #9a9a9a 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .error-container {
            max-width: 600px;
            margin: 20px;
            padding: 40px;
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
            animation: fadeIn 0.5s ease-in-out;
        }
        
        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .error-icon {
            font-size: 80px;
            margin-bottom: 20px;
        }
        
        .error-title {
            color: #721c24;
            font-size: 32px;
            margin-bottom: 15px;
            font-weight: bold;
        }
        
        .error-message {
            color: #555;
            font-size: 18px;
            margin-bottom: 30px;
            line-height: 1.6;
            padding: 15px;
            background: #f8d7da;
            border-radius: 10px;
            border-left: 5px solid #dc3545;
        }
        
        .error-suggestion {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            padding: 15px;
            background: #f0f0f0;
            border-radius: 10px;
        }
        
        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }
        
        .btn {
            display: inline-block;
            padding: 12px 25px;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
        }
        
        .btn-primary {
            background: #007bff;
            color: white;
            border: none;
        }
        
        .btn-primary:hover {
            background: #0056b3;
            transform: translateY(-2px);
        }
        
        .btn-success {
            background: #28a745;
            color: white;
            border: none;
        }
        
        .btn-success:hover {
            background: #1e7e34;
            transform: translateY(-2px);
        }
        
        .btn-warning {
            background: #ffc107;
            color: #333;
            border: none;
        }
        
        .btn-warning:hover {
            background: #e0a800;
            transform: translateY(-2px);
        }
        
        .btn-danger {
            background: #dc3545;
            color: white;
            border: none;
        }
        
        .btn-danger:hover {
            background: #bd2130;
            transform: translateY(-2px);
        }
        
        .home-link {
            display: inline-block;
            margin-top: 20px;
            color: #007bff;
            text-decoration: none;
        }
        
        .home-link:hover {
            text-decoration: underline;
        }
        
        @media (max-width: 480px) {
            .error-container {
                padding: 25px;
            }
            .error-title {
                font-size: 24px;
            }
            .btn {
                padding: 10px 18px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            ⛔
        </div>
        <h1 class="error-title">Доступ запрещён!</h1>
        <div class="error-message">
            <?= htmlspecialchars($error_message) ?>
        </div>
        
        <div class="error-suggestion">
            <strong>Возможные решения:</strong><br>
            • Убедитесь, что вы вошли в систему<br>
            • Проверьте, есть ли у вас нужные права доступа<br>
            • Обратитесь к администратору
        </div>
        
        <div class="button-group">
            <a href="<?= BASE_PATH ?>/?action=home" class="btn btn-primary">🏠 На главную</a>
            
            <?php if (!isset($_SESSION['user_id'])): ?>
                <a href="<?= BASE_PATH ?>/?action=login" class="btn btn-success">🔐 Войти</a>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] == 'reader'): ?>
                <a href="<?= BASE_PATH ?>/?action=become-author" class="btn btn-warning">Стать автором</a>
            <?php endif; ?>
            
            <?php if (isset($_SESSION['user_id']) && $_SESSION['role'] != 'admin'): ?>
                <a href="javascript:history.back()" class="btn btn-danger">◀ Назад</a>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>