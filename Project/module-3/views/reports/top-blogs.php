<?php include __DIR__ . '/../layout.php'; ?>
<h1>🏆 Отчёт: Топ блогов по подписчикам</h1>
<p><a href="<?= BASE_PATH ?>/?action=reports" class="btn">← Назад к отчётам</a></p>

<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead style="background-color: #333; color: white;">
        <tr>
            <th>ID</th>
            <th>Название блога</th>
            <th>Владелец</th>
            <th>Статей</th>
            <th>Подписчиков</th>
            <th>Всего просмотров</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['blog_name']) ?></td>
            <td><?= htmlspecialchars($row['owner_name']) ?></td>
            <td><?= $row['posts_count'] ?></td>
            <td><strong><?= $row['subscribers_count'] ?></strong></td>
            <td><?= $row['total_views'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php include __DIR__ . '/../footer.php'; ?>