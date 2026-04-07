<?php include __DIR__ . '/../layout.php'; ?>
<h1>🔐 Вход в систему</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<form method="POST" action="<?= BASE_PATH ?>/?action=do-login">
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль" required>
    <button type="submit">Войти</button>
</form>

<p style="margin-top: 15px;">Нет аккаунта? <a href="<?= BASE_PATH ?>/?action=register">Зарегистрироваться</a></p>
<p style="margin-top: 10px; font-size: 12px; color: gray;">Тестовые: admin@blog.com / password | john@blog.com / password | mike@blog.com / password</p>

<?php include __DIR__ . '/../footer.php'; ?>