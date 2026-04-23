<?php include __DIR__ . '/../layout.php'; ?>

<style>
    .action-buttons {
        display: flex;
        gap: 10px;
        flex-wrap: wrap;
        justify-content: center;
    }
    .btn-edit {
        background: #ffc107;
        color: #333;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        font-weight: bold;
    }
    .btn-edit:hover {
        background: #e0a800;
        transform: translateY(-2px);
    }
    .btn-delete {
        background: #dc3545;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        font-weight: bold;
    }
    .btn-delete:hover {
        background: #bd2130;
        transform: translateY(-2px);
    }
    .btn-view {
        background: #17a2b8;
        color: white;
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 13px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
        font-weight: bold;
    }
    .btn-view:hover {
        background: #138496;
        transform: translateY(-2px);
    }
    
    /* Стили для таблицы */
    .posts-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .posts-table thead tr {
        background: #1a1a1a;
    }
    .posts-table th {
        padding: 15px;
        text-align: left;
        color: #ffffff !important;
        font-weight: bold;
        font-size: 15px;
        background: #1a1a1a;
    }
    .posts-table th:nth-child(2),
    .posts-table th:nth-child(3),
    .posts-table th:nth-child(4) {
        text-align: center;
    }
    .posts-table td {
        padding: 15px;
        border-bottom: 1px solid #e0e0e0;
        vertical-align: middle;
    }
    .posts-table td:nth-child(2),
    .posts-table td:nth-child(3),
    .posts-table td:nth-child(4) {
        text-align: center;
    }
    .posts-table tbody tr:hover {
        background: #f8f9fa;
        transition: background 0.3s;
    }
    .views-badge {
        background: #e9ecef;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 13px;
        font-weight: bold;
        color: #495057;
        display: inline-block;
    }
    .post-title {
        font-weight: bold;
        color: #2c3e50;
    }
</style>

<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (!$blog): ?>
    <!-- Форма создания блога -->
    <div style="max-width: 600px; margin: 0 auto;">
        <h1>📝 Создать блог</h1>
        <p style="color: #666; margin-bottom: 20px;">Создайте свой блог, чтобы начать публиковать статьи</p>
        
        <form method="POST" action="<?= BASE_PATH ?>/?action=do-create-blog" style="background: white; padding: 25px; border-radius: 15px; box-shadow: 0 5px 20px rgba(0,0,0,0.1);">
            <div style="margin-bottom: 15px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">🏷️ Название блога</label>
                <input type="text" name="name" placeholder="Например: Блог о программировании" required style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label style="display: block; margin-bottom: 8px; font-weight: bold;">📝 Описание</label>
                <textarea name="description" placeholder="Расскажите о чём ваш блог..." rows="4" style="width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 8px;"></textarea>
            </div>
            <button type="submit" style="width: 100%; padding: 14px; background: linear-gradient(135deg, #28a745 0%, #20c997 100%); color: white; border: none; border-radius: 8px; font-size: 16px; font-weight: bold; cursor: pointer;">
                🚀 Создать блог
            </button>
        </form>
    </div>
    
<?php else: ?>
    <!-- Информация о блоге -->
    <div style="background: #007bff; border-radius: 20px; padding: 30px; color: white; margin-bottom: 30px;">
        <h1 style="font-size: 36px; margin-bottom: 10px;">📝 <?= htmlspecialchars($blog['name']) ?></h1>
        <p style="font-size: 18px; opacity: 0.95; margin-bottom: 20px;"><?= htmlspecialchars($blog['description']) ?></p>
        <div style="display: flex; gap: 15px; flex-wrap: wrap;">
            <a href="<?= BASE_PATH ?>/?action=edit-blog" class="btn" style="background: white; color: #0073ff; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                ✏️ Редактировать блог
            </a>
            <a href="<?= BASE_PATH ?>/?action=create-post" class="btn" style="background: #28a745; color: white; padding: 10px 20px; border-radius: 8px; text-decoration: none; font-weight: bold;">
                ➕ Новая статья
            </a>
        </div>
    </div>
    
    <!-- Список статей -->
    <h2 style="margin: 30px 0 20px; color: #2c3e50;">📚 Мои статьи</h2>
    
    <?php if (empty($posts)): ?>
        <div class="post-card" style="text-align: center; padding: 40px; background: #f8f9fa; border-radius: 15px;">
            <p style="font-size: 18px; color: #666;">📭 У вас пока нет статей.</p>
            <a href="<?= BASE_PATH ?>/?action=create-post" class="btn btn-success" style="margin-top: 15px; padding: 12px 25px;">
                ➕ Создать первую статью
            </a>
        </div>
    <?php else: ?>
        <table class="posts-table">
            <thead>
                <tr>
                    <th style="color: #ffffff !important; background: #1a1a1a;">📌 Заголовок</th>
                    <th style="color: #ffffff !important; background: #1a1a1a;">👁️ Просмотры</th>
                    <th style="color: #ffffff !important; background: #1a1a1a;">📅 Дата</th>
                    <th style="color: #ffffff !important; background: #1a1a1a;">⚡ Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($posts as $post): ?>
                <tr style="border-bottom: 1px solid #e0e0e0;">
                    <td>
                        <span class="post-title"><?= htmlspecialchars($post['title']) ?></span>
                    </td>
                    <td>
                        <span class="views-badge">👁️ <?= $post['views_count'] ?></span>
                    </td>
                    <td style="color: #666;">
                        <?= date('d.m.Y H:i', strtotime($post['created_at'])) ?>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <a href="<?= BASE_PATH ?>/?action=view-post&id=<?= $post['id'] ?>" class="btn-view" title="Просмотреть">
                                👁️ Просмотр
                            </a>
                            <a href="<?= BASE_PATH ?>/?action=edit-post&id=<?= $post['id'] ?>" class="btn-edit" title="Редактировать">
                                ✏️ Редакт.
                            </a>
                            <a href="<?= BASE_PATH ?>/?action=delete-post&id=<?= $post['id'] ?>" class="btn-delete" title="Удалить" onclick="return confirm('❓ Вы уверены, что хотите удалить статью «<?= htmlspecialchars($post['title']) ?>»? Это действие нельзя отменить.')">
                                🗑️ Удалить
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
    
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>