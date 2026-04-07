<?php include __DIR__ . '/../layout.php'; ?>
<h1>➕ Создать блог</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<form method="POST" action="<?= BASE_PATH ?>/?action=do-create-blog">
    <input type="text" name="name" placeholder="Название блога" required>
    <textarea name="description" placeholder="Описание блога" rows="5"></textarea>
    <button type="submit">Создать</button>
</form>

<?php include __DIR__ . '/../footer.php'; ?>