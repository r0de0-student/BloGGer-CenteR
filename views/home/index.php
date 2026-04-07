<?php include __DIR__ . '/../layout.php'; ?>
<h1>📖 Все статьи</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (empty($posts)): ?>
    <p>Пока нет статей. Станьте автором и создайте первую!</p>
<?php else: ?>
    <?php foreach($posts as $post): ?>
        <div class="post-card">
            <h3><?= htmlspecialchars($post['title']) ?></h3>
            <p><small>📝 Автор: <?= htmlspecialchars($post['author_name']) ?> | 👁️ <?= $post['views_count'] ?> просмотров | 📅 <?= $post['created_at'] ?></small></p>
            <p><?= htmlspecialchars(mb_substr($post['content'], 0, 200)) ?>...</p>
            <a href="<?= BASE_PATH ?>/?action=view-post&id=<?= $post['id'] ?>" class="btn">Читать далее →</a>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>