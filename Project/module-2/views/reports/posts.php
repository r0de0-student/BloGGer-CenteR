<?php include __DIR__ . '/../layout.php'; ?>
<h1>📄 Отчёт: Статьи и просмотры</h1>
<p><a href="<?= BASE_PATH ?>/?action=reports" class="btn">← Назад к отчётам</a></p>

<table border="1" cellpadding="8" cellspacing="0" style="width: 100%; border-collapse: collapse; margin-top: 20px;">
    <thead style="background-color: #333; color: white;">
        <tr>
            <th>ID</th>
            <th>Заголовок</th>
            <th>Автор</th>
            <th>Блог</th>
            <th>Просмотры</th>
            <th>Дата публикации</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach($data as $row): ?>
        <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['title']) ?></td>
            <td><?= htmlspecialchars($row['author_name']) ?></td>
            <td><?= htmlspecialchars($row['blog_name']) ?></td>
            <td><?= $row['views_count'] ?></td>
            <td><?= $row['pub_date'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p style="margin-top: 20px;"><strong>Всего статей:</strong> <?= count($data) ?></p>
<p><strong>Общее количество просмотров:</strong> <?= array_sum(array_column($data, 'views_count')) ?></p>

<?php include __DIR__ . '/../footer.php'; ?>