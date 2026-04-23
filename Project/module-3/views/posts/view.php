<?php include __DIR__ . '/../layout.php'; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<h1><?= htmlspecialchars($post['title']) ?></h1>
<p><small>📝 Автор: <?= htmlspecialchars($post['author_name']) ?> | 👁️ <?= $post['views_count'] ?> просмотров | 📅 <?= $post['created_at'] ?></small></p>
<div style="margin: 20px 0; line-height: 1.6;"><?= nl2br(htmlspecialchars($post['content'])) ?></div>

<h3>💬 Комментарии (<?= count($comments) ?>)</h3>

<?php if (isset($_SESSION['user_id'])): ?>
    <form method="POST" action="<?= BASE_PATH ?>/?action=add-comment&id=<?= $post['id'] ?>" style="margin-bottom: 20px;">
        <textarea name="content" placeholder="Написать комментарий..." rows="3" required></textarea>
        <button type="submit">Отправить</button>
    </form>
<?php else: ?>
    <p><a href="<?= BASE_PATH ?>/?action=login">Войдите</a>, чтобы оставить комментарий</p>
<?php endif; ?>

<?php foreach($comments as $comment): ?>
    <div class="comment">
        <strong><?= htmlspecialchars($comment['user_name']) ?></strong> 
        <small><?= $comment['created_at'] ?></small>
        <p><?= nl2br(htmlspecialchars($comment['content'])) ?></p>
    </div>
<?php endforeach; ?>

<?php include __DIR__ . '/../footer.php'; ?>