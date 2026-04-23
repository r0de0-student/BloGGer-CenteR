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
    .blogs-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .blogs-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .blogs-table td:nth-child(4),
    .blogs-table td:nth-child(5) {
        text-align: center;
    }
    .blogs-table tbody tr:hover {
        background: #f8f9fa;
        transition: background 0.3s;
    }
    .rank-number {
        display: inline-block;
        width: 30px;
        height: 30px;
        color: white;
        border-radius: 50%;
        text-align: center;
        line-height: 30px;
        font-weight: bold;
        font-size: 14px;
    }
    .blog-name {
        font-weight: bold;
        color: #2c3e50;
    }
    .owner-name {
        color: #007bff;
    }
    .posts-count {
        display: inline-block;
        background: #e9ecef;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        color: #495057;
    }
    .views-count {
        display: inline-block;
        background: #e9ecef;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        color: #495057;
    }
    .footer-note {
        margin-top: 25px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 10px;
        text-align: center;
        color: #666;
    }
    @media (max-width: 768px) {
        .report-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
        }
        .blogs-table {
            font-size: 12px;
        }
        .blogs-table td, .blogs-table th {
            padding: 8px;
        }
    }
</style>

<div class="report-header">
    <h1>
        <span>🏆</span> Отчёт: Топ блогов
    </h1>
    <a href="<?= BASE_PATH ?>/?action=reports" class="back-btn">
        ← Назад к отчётам
    </a>
</div>

<div class="stats-summary">
    <div class="stat-box">
        <div class="icon">📚</div>
        <div class="info">
            <div class="value"><?= count($data) ?></div>
            <div class="label">Всего блогов</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="icon">📄</div>
        <div class="info">
            <div class="value"><?= array_sum(array_column($data, 'posts_count')) ?></div>
            <div class="label">Всего статей</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="icon">👁️</div>
        <div class="info">
            <div class="value"><?= array_sum(array_column($data, 'total_views')) ?></div>
            <div class="label">Всего просмотров</div>
        </div>
    </div>
</div>

<table class="blogs-table">
    <thead>
        <tr style="background: #1a1a1a;">
            <th style="padding: 15px; text-align: center; color: white; background: #1a1a1a; font-weight: bold;">#</th>
            <th style="padding: 15px; text-align: left; color: white; background: #1a1a1a; font-weight: bold;">Название блога</th>
            <th style="padding: 15px; text-align: left; color: white; background: #1a1a1a; font-weight: bold;">Владелец</th>
            <th style="padding: 15px; text-align: center; color: white; background: #1a1a1a; font-weight: bold;">📄 Статей</th>
            <th style="padding: 15px; text-align: center; color: white; background: #1a1a1a; font-weight: bold;">👁️ Просмотров</th>
        </tr>
    </thead>
    <tbody>
        <?php $rank = 1; ?>
        <?php foreach($data as $row): ?>
        <tr>
            <td style="text-align: center;">
                <?php if ($rank == 1): ?>
                    <span class="rank-number">🥇</span>
                <?php elseif ($rank == 2): ?>
                    <span class="rank-number">🥈</span>
                <?php elseif ($rank == 3): ?>
                    <span class="rank-number">🥉</span>
                <?php else: ?>
                    <span class="rank-number"><?= $rank ?></span>
                <?php endif; ?>
            </td>
            <td><span class="blog-name"><?= htmlspecialchars($row['blog_name']) ?></span></td>
            <td><span class="owner-name"><?= htmlspecialchars($row['owner_name']) ?></span></td>
            <td><span class="posts-count">📄 <?= $row['posts_count'] ?></span></td>
            <td><span class="views-count">👁️ <?= $row['total_views'] ?></span></td>
        </tr>
        <?php $rank++; ?>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../footer.php'; ?>