<?php include __DIR__ . '/../layout.php'; ?>
<h1>✏️ Редактировать статью</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form method="POST" action="<?= BASE_PATH ?>/?action=do-update-post&id=<?= $_GET['id'] ?>">
    <input type="text" name="title" value="<?= htmlspecialchars($post['title']) ?>" required>
    <textarea name="content" rows="10" required><?= htmlspecialchars($post['content']) ?></textarea>
    <button type="submit">Сохранить</button>
</form>

<?php include __DIR__ . '/../footer.php'; ?>