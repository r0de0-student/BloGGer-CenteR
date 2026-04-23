<?php include __DIR__ . '/../layout.php'; ?>
<h1>📚 Все блоги</h1>

<?php if (empty($blogs)): ?>
    <p>Пока нет блогов. Станьте автором и создайте первый!</p>
<?php else: ?>
    <?php foreach($blogs as $blog): ?>
        <div class="post-card">
            <h3><?= htmlspecialchars($blog['name']) ?></h3>
            <p><?= htmlspecialchars($blog['description']) ?></p>
            <p><small>👤 Владелец: <?= htmlspecialchars($blog['owner_name']) ?> | 📄 Статей: <?= $blog['posts_count'] ?? 0 ?> | 👥 Подписчиков: <?= $blog['subscribers_count'] ?? 0 ?></small></p>
        </div>
    <?php endforeach; ?>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>