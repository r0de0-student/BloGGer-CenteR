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
    .users-table {
        width: 100%;
        border-collapse: collapse;
        background: white;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .users-table thead tr {
        background: #1a1a1a;  /* ЧЁРНЫЙ ФОН */
    }
    .users-table th {
        padding: 15px;
        text-align: left;
        color: #ffffff !important;  /* БЕЛЫЙ ТЕКСТ */
        font-weight: bold;
        font-size: 14px;
    }
    .users-table th:nth-child(2),
    .users-table th:nth-child(3) {
        text-align: left;
    }
    .users-table th:nth-child(4),
    .users-table th:nth-child(5),
    .users-table th:nth-child(6) {
        text-align: center;
    }
    .users-table td {
        padding: 12px 15px;
        border-bottom: 1px solid #f0f0f0;
        vertical-align: middle;
    }
    .users-table td:nth-child(4),
    .users-table td:nth-child(5),
    .users-table td:nth-child(6) {
        text-align: center;
    }
    .users-table tbody tr:hover {
        background: #f8f9fa;
        transition: background 0.3s;
    }
    .role-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }
    .role-admin {
        background: #dc3545;
        color: white;
    }
    .role-author {
        background: #28a745;
        color: white;
    }
    .status-badge {
        display: inline-block;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: bold;
    }
    .status-active {
        background: #d4edda;
        color: #155724;
    }
    .status-blocked {
        background: #f8d7da;
        color: #721c24;
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
        <span>👥</span> Отчёт: Пользователи системы
    </h1>
    <a href="<?= BASE_PATH ?>/?action=reports" class="back-btn">
        ← Назад к отчётам
    </a>
</div>

<div class="stats-summary">
    <div class="stat-box">
        <div class="icon">👥</div>
        <div class="info">
            <div class="value"><?= count($data) ?></div>
            <div class="label">Всего пользователей</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="icon">👑</div>
        <div class="info">
            <div class="value">
                <?= count(array_filter($data, function($u) { return $u['role'] == 'admin'; })) ?>
            </div>
            <div class="label">Администраторов</div>
        </div>
    </div>
    <div class="stat-box">
        <div class="icon">✍️</div>
        <div class="info">
            <div class="value">
                <?= count(array_filter($data, function($u) { return $u['role'] == 'author'; })) ?>
            </div>
            <div class="label">Авторов</div>
        </div>
    </div>
</div>

<table class="users-table">
    <thead>
        <tr style="background: #1a1a1a;">
            <th style="padding: 15px; text-align: left; color: white; background: #1a1a1a; font-weight: bold;">ID</th>
            <th style="padding: 15px; text-align: left; color: white; background: #1a1a1a; font-weight: bold;">Имя</th>
            <th style="padding: 15px; text-align: left; color: white; background: #1a1a1a; font-weight: bold;">Email</th>
            <th style="padding: 15px; text-align: center; color: white; background: #1a1a1a; font-weight: bold;">Роль</th>
            <th style="padding: 15px; text-align: center; color: white; background: #1a1a1a; font-weight: bold;">Статус</th>
            <th style="padding: 15px; text-align: center; color: white; background: #1a1a1a; font-weight: bold;">Дата регистрации</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td>
                <span class="role-badge <?= $row['role'] == 'admin' ? 'role-admin' : 'role-author' ?>">
                    <?= $row['role'] == 'admin' ? '👑 Админ' : '✍️ Автор' ?>
                </span>
            </td>
            <td>
                <span class="status-badge <?= $row['status'] == 'Активен' ? 'status-active' : 'status-blocked' ?>">
                    <?= $row['status'] == 'Активен' ? '✅ Активен' : '🔒 Заблокирован' ?>
                </span>
            </td>
            <td><?= $row['reg_date'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../footer.php'; ?>