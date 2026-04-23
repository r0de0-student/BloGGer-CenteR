<?php include __DIR__ . '/../layout.php'; ?>

<div style="max-width: 500px; margin: 0 auto;">
    <div style="text-align: center; margin-bottom: 30px;">
        <div style="font-size: 60px;">📝</div>
        <h1 style="color: #333; margin-top: 10px;">Регистрация</h1>
        <p style="color: #666;">Создайте аккаунт, чтобы начать</p>
    </div>

    <?php if (isset($_SESSION['errors'])): ?>
        <?php foreach($_SESSION['errors'] as $error): ?>
            <div class="alert alert-error" style="text-align: center;">
                <?= htmlspecialchars($error) ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['errors']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error" style="text-align: center;">
            <?= htmlspecialchars($_SESSION['error']) ?>
        </div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <form method="POST" action="<?= BASE_PATH ?>/?action=do-register" style="background: white; padding: 30px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">👤 Имя</label>
            <input type="text" name="name" placeholder="Введите ваше имя" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;">
        </div>
        
        <div style="margin-bottom: 20px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">📧 Email</label>
            <input type="email" name="email" placeholder="example@mail.com" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;">
        </div>
        
        <div style="margin-bottom: 25px;">
            <label style="display: block; margin-bottom: 8px; font-weight: bold; color: #333;">🔒 Пароль</label>
            <input type="password" name="password" placeholder="Минимум 6 символов" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px; font-size: 16px;">
        </div>
        
        <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer;">
            📝 Зарегистрироваться
        </button>
    </form>
    
    <div style="text-align: center; margin-top: 25px;">
        <p style="color: #666;">
            Уже есть аккаунт? 
            <a href="<?= BASE_PATH ?>/?action=login" style="color: #667eea; text-decoration: none; font-weight: bold;">Войти</a>
        </p>
    </div>
</div>

<?php include __DIR__ . '/../footer.php'; ?>