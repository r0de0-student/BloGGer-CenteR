<?php include __DIR__ . '/../layout.php'; ?>

<style>
    .report-header {
        background: #007bff;
        border-radius: 20px;
        padding: 30px;
        color: white;
        margin-bottom: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
    }
    .report-header h1 {
        font-size: 28px;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .back-btn {
        background: rgba(255,255,255,0.2);
        color: white;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .back-btn:hover {
        background: rgba(255,255,255,0.3);
        transform: translateX(-3px);
    }
    .stats-summary {
        display: flex;
        gap: 20px;
        margin-bottom: 25px;
        flex-wrap: wrap;
    }
    .stat-box {
        background: white;
        border-radius: 15px;
        padding: 15px 25px;
        box-shadow: 0 5px 15px rgba(0,0,0,0.08);
        display: flex;
        align-items: center;
        gap: 15px;
    }
    .stat-box .icon {
        font-size: 32px;
    }
    .stat-box .info {
        display: flex;
        flex-direction: column;
    }
    .stat-box .value {
        font-size: 28px;
        font-weight: bold;
        color: #2c3e50;
    }
    .stat-box .label {
        font-size: 14px;
        color: #666;
    }
    .posts-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .posts-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .posts-table td:nth-child(5),
    .posts-table td:nth-child(6) {
        text-align: center;
    }
    .posts-table tbody tr:hover {
        background: #f8f9fa;
        transition: background 0.3s;
    }
    .views-badge {
        display: inline-block;
        background: #e9ecef;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        color: #495057;
    }
    .post-title {
        font-weight: bold;
        color: #2c3e50;
    }
    .author-name {
        color: #007bff;
    }
    .blog-name {
        color: #28a745;
    }
    .footer-note {
        margin-top: 25px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        text-align: center;
        color: #666;
    }
    
</style>

<div class="report-header">
    <h1>
        <span>📄</span> Отчёт: Статьи и просмотры
    </h1>
    <a href="<?= BASE_PATH ?>/?action=reports" class="back-btn">
        ← Назад к отчётам
    </a>
</div>

<div class="stats-summary">
    <div class="stat-box">
        <div class="icon">📄</div>
        <div class="info">
            <div class="value"><?= count($data) ?></div>
            <div class="label">Всего статей</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="icon">👁️</div>
        <div class="info">
            <div class="value"><?= array_sum(array_column($data, 'views_count')) ?></div>
            <div class="label">Всего просмотров</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="icon">⭐</div>
        <div class="info">
            <div class="value">
                <?php 
                $maxViews = !empty($data) ? max(array_column($data, 'views_count')) : 0;
                echo $maxViews;
                ?>
            </div>
            <div class="label">Макс. просмотров</div>
        </div>
    </div>
</div>

<table class="posts-table">
    <thead>
        <tr style="background: #1a1a1a;">
            <th style="padding: 15px; text-align: left; color: white; background: #1a1a1a; font-weight: bold;">ID</th>
            <th style="padding: 15px; text-align: left; color: white; background: #1a1a1a; font-weight: bold;">Заголовок</th>
            <th style="padding: 15px; text-align: left; color: white; background: #1a1a1a; font-weight: bold;">Автор</th>
            <th style="padding: 15px; text-align: left; color: white; background: #1a1a1a; font-weight: bold;">Блог</th>
            <th style="padding: 15px; text-align: center; color: white; background: #1a1a1a; font-weight: bold;">👁️ Просмотры</th>
            <th style="padding: 15px; text-align: center; color: white; background: #1a1a1a; font-weight: bold;">📅 Дата публикации</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><span class="post-title"><?= htmlspecialchars($row['title']) ?></span></td>
            <td><span class="author-name"><?= htmlspecialchars($row['author_name']) ?></span></td>
            <td><span class="blog-name"><?= htmlspecialchars($row['blog_name']) ?></span></td>
            <td><span class="views-badge">👁️ <?= $row['views_count'] ?></span></td>
            <td><?= $row['pub_date'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../footer.php'; ?>