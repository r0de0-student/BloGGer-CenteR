<?php include __DIR__ . '/../layout.php'; ?>

<div style="max-width: 500px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 30px;">
        <div style="font-size: 60px;">🔐</div>
        <h1 style="color: #333; margin-top: 10px;">Вход в систему</h1>
        <p style="color: #666;">Войдите, чтобы продолжить</p>
    </div>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error" style="text-align: center;">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success" style="text-align: center;">
            <?= htmlspecialchars($_SESSION['success']) ?>
        </div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_PATH ?>/?action=do-login" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">📧 Email</label>
            <input type="email" name="email" placeholder="example@mail.com" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">🔒 Пароль</label>
            <input type="password" name="password" placeholder="••••••" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;">
        </div>
        
        <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer;">
            🔐 Войти
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 25px;">
        <p style="color: #666;">
            Нет аккаунта? 
            <a href="<?= BASE_PATH ?>/?action=register" style="color: #667eea; text-decoration: none; font-weight: bold;">Зарегистрироваться</a>
        </p>
    </div>
    
    <div style="background: #f8f9fa; border-radius: 10px; padding: 15px; margin-top: 30px; text-align: center;">
        <p style="margin: 0 0 10px 0; font-weight: bold; color: #333;">📋 Тестовые аккаунты</p>
        <p style="margin: 5px 0; font-size: 13px; color: #666;">👑 Админ: admin@blog.com / password</p>
        <p style="margin: 5px 0; font-size: 13px; color: #666;">✍️ Автор: john@blog.com / password</p>
        <p style="margin: 5px 0; font-size: 13px; color: #666;">📖 Читатель: mike@blog.com / password</p>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>