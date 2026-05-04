<?php include __DIR__ . '/../layout.php'; ?>
<h1>✏️ Редактировать блог</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form method="POST" action="<?= BASE_PATH ?>/?action=do-update-blog">
    <input type="text" name="name" value="<?= htmlspecialchars($blog['name']) ?>" required>
    <textarea name="description" rows="5"><?= htmlspecialchars($blog['description']) ?></textarea>
    <button type="submit">Сохранить</button>
</form>

<?php include __DIR__ . '/../footer.php'; ?>