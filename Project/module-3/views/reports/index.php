<?php include __DIR__ . '/../layout.php'; ?>

<h1>📊 Отчёты системы</h1>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<p>Выберите отчёт для просмотра или выгрузки в Excel/Word.</p>

<div style="display: flex; gap: 20px; flex-wrap: wrap; margin-top: 20px;">
    
    <?php if ($_SESSION['role'] == 'admin'): ?>
    
    <!-- Отчёт 1: Пользователи (только админ) -->
    <div class="post-card" style="width: 300px;">
        <h3>👥 Пользователи системы</h3>
        <p>Список всех пользователей с ролями, статусом и датой регистрации.</p>
        <p><small>Доступ: Администратор</small></p>
        <div style="margin-top: 15px;">
            <a href="<?= BASE_PATH ?>/?action=report-users" class="btn">📄 Смотреть</a>
            <a href="<?= BASE_PATH ?>/?action=export-users-excel" class="btn btn-success">📊 Excel</a>
            <a href="<?= BASE_PATH ?>/?action=export-users-word" class="btn btn-success">📝 Word</a>
        </div>
    </div>
    
    <!-- Отчёт 2: Статьи (только админ) -->
    <div class="post-card" style="width: 300px;">
        <h3>📄 Статьи и просмотры</h3>
        <p>Все статьи с авторами, блогами, просмотрами и датой публикации.</p>
        <p><small>Доступ: Администратор</small></p>
        <div style="margin-top: 15px;">
            <a href="<?= BASE_PATH ?>/?action=report-posts" class="btn">📄 Смотреть</a>
            <a href="<?= BASE_PATH ?>/?action=export-posts-excel" class="btn btn-success">📊 Excel</a>
            <a href="<?= BASE_PATH ?>/?action=export-posts-word" class="btn btn-success">📝 Word</a>
        </div>
    </div>
    
    <!-- Отчёт 3: Топ блогов (только админ) -->
    <div class="post-card" style="width: 300px;">
        <h3>🏆 Топ блогов</h3>
        <p>Рейтинг блогов по количеству подписчиков, статей и просмотров.</p>
        <p><small>Доступ: Администратор</small></p>
        <div style="margin-top: 15px;">
            <a href="<?= BASE_PATH ?>/?action=report-top-blogs" class="btn">📄 Смотреть</a>
            <a href="<?= BASE_PATH ?>/?action=export-top-blogs-excel" class="btn btn-success">📊 Excel</a>
            <a href="<?= BASE_PATH ?>/?action=export-top-blogs-word" class="btn btn-success">📝 Word</a>
        </div>
    </div>
    
    <?php endif; ?>
    
    <!-- Отчёт 4: Статистика автора (для всех авторизованных) -->
    <div class="post-card" style="width: 300px;">
        <h3>📈 Моя статистика</h3>
        <p>Персональная статистика: блоги, статьи, просмотры, комментарии, подписчики.</p>
        <p><small>Доступ: Автор</small></p>
        <div style="margin-top: 15px;">
            <a href="<?= BASE_PATH ?>/?action=author-stats" class="btn">📄 Смотреть</a>
        </div>
    </div>
    
</div>

<?php include __DIR__ . '/../footer.php'; ?>