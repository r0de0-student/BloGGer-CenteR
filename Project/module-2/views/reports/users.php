<?php include __DIR__ . '/../layout.php'; ?>
<h1>👥 Отчёт: Пользователи системы</h1>
<p><a href="<?= BASE_PATH ?>/?action=reports" class="btn">← Назад к отчётам</a></p>

<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead style="background-color: #333; color: white;">
        <tr>
            <th>ID</th>
            <th>Имя</th>
            <th>Email</th>
            <th>Роль</th>
            <th>Статус</th>
            <th>Дата регистрации</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['name']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= $row['role'] ?></td>
            <td><?= $row['status'] ?></td>
            <td><?= $row['reg_date'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p style="margin-top: 20px;"><strong>Всего пользователей:</strong> <?= count($data) ?></p>

<?php include __DIR__ . '/../footer.php'; ?>