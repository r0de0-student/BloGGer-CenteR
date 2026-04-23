<?php include __DIR__ . '/../layout.php'; ?>

<style>
    .stats-header {
        background: #007bff;
        border-radius: 20px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        text-align: center;
    }
    .stats-header h1 {
        font-size: 36px;
        margin-bottom: 10px;
    }
    .stats-header p {
        font-size: 18px;
        opacity: 0.9;
    }
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        margin-top: 15px;
        transition: all 0.2s;
    }
    .back-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateX(-3px);
    }
    .stats-grid {
        display: flex;
        gap: 25px;
        flex-wrap: wrap;
        justify-content: center;
        margin-top: 20px;
    }
    .stat-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        text-align: center;
        min-width: 180px;
        flex: 1;
        box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        transition: transform 0.3s, box-shadow 0.3s;
        border-bottom: 4px solid;
    }
    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 40px rgba(0,0,0,0.15);
    }
    .stat-number {
        font-size: 48px;
        font-weight: bold;
        margin-bottom: 10px;
    }
    .stat-label {
        font-size: 16px;
        color: #666;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
    }
    .stat-label span {
        font-size: 24px;
    }
    
    /* Цвета для карточек */
    .stat-card.blogs { border-bottom-color: #007bff; }
    .stat-card.blogs .stat-number { color: #007bff; }
    
    .stat-card.posts { border-bottom-color: #28a745; }
    .stat-card.posts .stat-number { color: #28a745; }
    
    .stat-card.views { border-bottom-color: #ffc107; }
    .stat-card.views .stat-number { color: #ffc107; }
    
    .stat-card.comments { border-bottom-color: #17a2b8; }
    .stat-card.comments .stat-number { color: #17a2b8; }
    
    .stat-card.subscribers { border-bottom-color: #dc3545; }
    .stat-card.subscribers .stat-number { color: #dc3545; }
    
    @media (max-width: 768px) {
        .stat-card { min-width: 140px; }
        .stat-number { font-size: 32px; }
    }
</style>

<div class="stats-header">
    <h1>📈 Моя статистика</h1>
    <p>Ваша активность на платформе BloGGing CenteR</p>
    <a href="<?= BASE_PATH ?>/?action=reports" class="back-btn">
        ← Назад к отчётам
    </a>
</div>

<div class="stats-grid">
    <!-- Блоги -->
    <div class="stat-card blogs">
        <div class="stat-number"><?= number_format($stats['blogs_count'] ?? 0) ?></div>
        <div class="stat-label">
            <span>📝</span> Блогов
        </div>
    </div>
    
    <!-- Статьи -->
    <div class="stat-card posts">
        <div class="stat-number"><?= number_format($stats['posts_count'] ?? 0) ?></div>
        <div class="stat-label">
            <span>📄</span> Статей
        </div>
    </div>
    
    <!-- Просмотры -->
    <div class="stat-card views">
        <div class="stat-number"><?= number_format($stats['total_views'] ?? 0) ?></div>
        <div class="stat-label">
            <span>👁️</span> Просмотров
        </div>
    </div>
    
    <!-- Комментарии -->
    <div class="stat-card comments">
        <div class="stat-number"><?= number_format($stats['comments_count'] ?? 0) ?></div>
        <div class="stat-label">
            <span>💬</span> Комментариев
        </div>
    </div>
    
</div>

<?php if (($stats['posts_count'] ?? 0) == 0): ?>
<div style="text-align: center; margin-top: 40px; padding: 30px; background: #f8f9fa; border-radius: 15px;">
    <p style="font-size: 18px; color: #666;">📭 У вас пока нет статей.</p>
    <a href="<?= BASE_PATH ?>/?action=create-post" class="btn btn-success" style="margin-top: 10px;">
        ➕ Создать первую статью
    </a>
</div>
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>