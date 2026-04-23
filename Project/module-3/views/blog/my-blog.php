<?php include __DIR__ . '/../layout.php'; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!$blog): ?>
    <h1>📝 Создать блог</h1>
    <form method="POST" action="<?= BASE_PATH ?>/?action=do-create-blog">
        <input type="text" name="name" placeholder="Название блога" required>
        <textarea name="description" placeholder="Описание блога" rows="3"></textarea>
        <button type="submit">Создать блог</button>
    </form>
<?php else: ?>
    <h1>📝 <?= htmlspecialchars($blog['name']) ?></h1>
    <p><?= htmlspecialchars($blog['description']) ?></p>
    <a href="<?= BASE_PATH ?>/?action=edit-blog" class="btn">✏️ Редактировать блог</a>
    <a href="<?= BASE_PATH ?>/?action=create-post" class="btn btn-success">➕ Новая статья</a>
    
    <h2 style="margin-top: 30px;">Мои статьи</h2>
    <?php if (empty($posts)): ?>
        <p>У вас пока нет статей. Создайте первую!</p>
    <?php else: ?>
        <table>
            <tr><th>Заголовок</th><th>Просмотры</th><th>Дата</th><th>Действия</th></tr>
            <?php foreach($posts as $post): ?>
            <tr>
                <td><?= htmlspecialchars($post['title']) ?></td>
                <td><?= $post['views_count'] ?></td>
                <td><?= $post['created_at'] ?></td>
                <td>
                    <a href="<?= BASE_PATH ?>/?action=edit-post&id=<?= $post['id'] ?>">✏️</a>
                    <a href="<?= BASE_PATH ?>/?action=delete-post&id=<?= $post['id'] ?>" onclick="return confirm('Удалить статью?')">❌</a>
                </td>
            </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>