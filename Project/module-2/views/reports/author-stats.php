<?php include __DIR__ . '/../layout.php'; ?>
<h1>📈 Моя статистика</h1>
<p><a href="<?= BASE_PATH ?>/?action=reports" class="btn">← Назад к отчётам</a></p>

<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
    
    <div class="post-card" style="width: 200px; text-align: center;">
        <h2 style="font-size: 36px; color: #007bff;"><?= $stats['blogs_count'] ?? 0 ?></h2>
        <p>📝 Блогов</p>
    </div>
    
    <div class="post-card" style="width: 200px; text-align: center;">
        <h2 style="font-size: 36px; color: #28a745;"><?= $stats['posts_count'] ?? 0 ?></h2>
        <p>📄 Статей</p>
    </div>
    
    <div class="post-card" style="width: 200px; text-align: center;">
        <h2 style="font-size: 36px; color: #ffc107;"><?= $stats['total_views'] ?? 0 ?></h2>
        <p>👁️ Просмотров</p>
    </div>
    
    <div class="post-card" style="width: 200px; text-align: center;">
        <h2 style="font-size: 36px; color: #17a2b8;"><?= $stats['comments_count'] ?? 0 ?></h2>
        <p>💬 Комментариев</p>
    </div>
    
    <div class="post-card" style="width: 200px; text-align: center;">
        <h2 style="font-size: 36px; color: #dc3545;"><?= $stats['subscribers_count'] ?? 0 ?></h2>
        <p>👥 Подписчиков</p>
    </div>
    
</div>

<?php include __DIR__ . '/../footer.php'; ?>