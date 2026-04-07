<?php include __DIR__ . '/../layout.php'; ?>
<h1>📝 Регистрация</h1>

<?php if (isset($_SESSION['errors'])): ?>
    <?php foreach($_SESSION['errors'] as $error): ?>
        <div class="alert-error"><?= htmlspecialchars($error) ?></div>
    <?php endforeach; ?>
    <?php unset($_SESSION['errors']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form method="POST" action="<?= BASE_PATH ?>/?action=do-register">
    <input type="text" name="name" placeholder="Имя" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="password" placeholder="Пароль (мин. 6 символов)" required>
    <button type="submit">Зарегистрироваться</button>
</form>

<p style="margin-top: 15px;">Уже есть аккаунт? <a href="<?= BASE_PATH ?>/?action=login">Войти</a></p>

<?php include __DIR__ . '/../footer.php'; ?>