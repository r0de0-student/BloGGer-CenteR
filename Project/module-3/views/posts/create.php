<?php include __DIR__ . '/../layout.php'; ?>
<h1>➕ Новая статья</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form method="POST" action="<?= BASE_PATH ?>/?action=do-create-post">
    <input type="text" name="title" placeholder="Заголовок" required>
    <textarea name="content" placeholder="Текст статьи" rows="10" required></textarea>
    <button type="submit">Опубликовать</button>
</form>

<?php include __DIR__ . '/../footer.php'; ?>