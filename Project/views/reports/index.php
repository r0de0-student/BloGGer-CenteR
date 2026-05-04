<?php include __DIR__ . '/../layout.php'; ?>

<style>
    .reports-container {
        display: flex;
        flex-direction: column;
        gap: 25px;
    }
    .report-card {
        background: white;
        border-radius: 20px;
        padding: 25px;
        box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        transition: transform 0.3s, box-shadow 0.3s;
        border-left: 5px solid #007bff;
    }
    .report-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 30px rgba(0,0,0,0.15);
    }
    .report-header {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-bottom: 15px;
    }
    .report-icon {
        font-size: 48px;
    }
    .report-title {
        font-size: 24px;
        font-weight: bold;
        color: #2c3e50;
        margin: 0;
    }
    .report-description {
        color: #666;
        margin-bottom: 15px;
        line-height: 1.5;
        padding-left: 63px;
    }
    .report-access {
        display: inline-block;
        background: #e9ecef;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        color: #495057;
        margin-left: 63px;
        margin-bottom: 15px;
    }
    .report-buttons {
        display: flex;
        gap: 12px;
        flex-wrap: wrap;
        margin-left: 63px;
    }
    .btn-report {
        padding: 10px 20px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: bold;
        font-size: 14px;
        transition: all 0.2s;
        display: inline-flex;
        align-items: center;
        gap: 8px;
    }
    .btn-report-view {
        background: #007bff;
        color: white;
        border: none;
    }
    .btn-report-view:hover {
        background: #0056b3;
        transform: translateY(-2px);
    }
    .btn-report-excel {
        background: #28a745;
        color: white;
        border: none;
    }
    .btn-report-excel:hover {
        background: #1e7e34;
        transform: translateY(-2px);
    }
    .btn-report-word {
        background: #dc3545;
        color: white;
        border: none;
    }
    .btn-report-word:hover {
        background: #bd2130;
        transform: translateY(-2px);
    }
    .stats-preview {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        border-radius: 15px;
        padding: 25px;
        color: white;
        margin-bottom: 25px;
    }
    .stats-preview h3 {
        margin-bottom: 15px;
        font-size: 22px;
    }
    .stats-grid {
        display: flex;
        gap: 20px;
        flex-wrap: wrap;
        justify-content: space-around;
    }
    .stat-item {
        text-align: center;
        flex: 1;
        min-width: 100px;
    }
    .stat-number {
        font-size: 32px;
        font-weight: bold;
    }
    .stat-label {
        font-size: 14px;
        opacity: 0.9;
    }
    .page-title {
        font-size: 32px;
        color: #2c3e50;
        margin-bottom: 10px;
    }
    .page-subtitle {
        color: #666;
        margin-bottom: 30px;
        font-size: 16px;
    }
</style>

<div class="reports-container">
    <h1 class="page-title">📊 Отчёты системы</h1>
    <p class="page-subtitle">Здесь вы можете просмотреть свою статистику полностью </p>


    <?php if ($_SESSION['role'] == 'admin'): ?>
        <!-- Отчёт 1: Пользователи (только админ) -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">👥</div>
                <h2 class="report-title">Пользователи системы</h2>
            </div>
            <p class="report-description">Список всех пользователей с ролями, статусом и датой регистрации.</p>
            <span class="report-access">🔒 Доступ: Администратор</span>
            <div class="report-buttons">
                <a href="<?= BASE_PATH ?>/?action=report-users" class="btn-report btn-report-view">📄 Смотреть</a>
                <a href="<?= BASE_PATH ?>/?action=export-users-excel" class="btn-report btn-report-excel">📊 Excel</a>
                <a href="<?= BASE_PATH ?>/?action=export-users-word" class="btn-report btn-report-word">📝 Word</a>
            </div>
        </div>

        <!-- Отчёт 2: Статьи (только админ) -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">📄</div>
                <h2 class="report-title">Статьи и просмотры</h2>
            </div>
            <p class="report-description">Все статьи с авторами, блогами, просмотрами и датой публикации.</p>
            <span class="report-access">🔒 Доступ: Администратор</span>
            <div class="report-buttons">
                <a href="<?= BASE_PATH ?>/?action=report-posts" class="btn-report btn-report-view">📄 Смотреть</a>
                <a href="<?= BASE_PATH ?>/?action=export-posts-excel" class="btn-report btn-report-excel">📊 Excel</a>
                <a href="<?= BASE_PATH ?>/?action=export-posts-word" class="btn-report btn-report-word">📝 Word</a>
            </div>
        </div>

        <!-- Отчёт 3: Топ блогов (только админ) -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">🏆</div>
                <h2 class="report-title">Топ блогов</h2>
            </div>
            <p class="report-description">Рейтинг блогов по количеству подписчиков, статей и просмотров.</p>
            <span class="report-access">🔒 Доступ: Администратор</span>
            <div class="report-buttons">
                <a href="<?= BASE_PATH ?>/?action=report-top-blogs" class="btn-report btn-report-view">📄 Смотреть</a>
                <a href="<?= BASE_PATH ?>/?action=export-top-blogs-excel" class="btn-report btn-report-excel">📊 Excel</a>
                <a href="<?= BASE_PATH ?>/?action=export-top-blogs-word" class="btn-report btn-report-word">📝 Word</a>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($_SESSION['role'] == 'author' || $_SESSION['role'] == 'admin'): ?>
        <!-- Отчёт 4: Моя статистика -->
        <div class="report-card">
            <div class="report-header">
                <div class="report-icon">📈</div>
                <h2 class="report-title">Моя статистика</h2>
            </div>
            <p class="report-description">Персональная статистика: блоги, статьи, просмотры, комментарии, подписчики.</p>
            <span class="report-access">🔒 Доступ: Автор</span>
            <div class="report-buttons">
                <a href="<?= BASE_PATH ?>/?action=author-stats" class="btn-report btn-report-view">📄 Смотреть</a>
            </div>
        </div>
    <?php endif; ?>
</div>

<?php include __DIR__ . '/../footer.php'; ?>