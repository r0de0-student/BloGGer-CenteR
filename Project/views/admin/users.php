<?php include __DIR__ . '/../layout.php'; ?>
<h1>👑 Управление пользователями</h1>

<?php if (isset($_SESSION['success'])): ?>
    <div class="alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<table>
    <tr>
        <th>ID</th>
        <th>Имя</th>
        <th>Email</th>
        <th>Роль</th>
        <th>Статус</th>
        <th>Действия</th>
    </tr>
    <?php foreach($users as $user): ?>
    <tr>
        <td><?= $user['id'] ?></td>
        <td><?= htmlspecialchars($user['name']) ?></td>
        <td><?= htmlspecialchars($user['email']) ?></td>
        <td><?= $user['role'] ?></td>
        <td><?= $user['is_blocked'] ? '🔒 Заблокирован' : '✅ Активен' ?></td>
        <td>
            <a href="<?= BASE_PATH ?>/?action=toggle-block&id=<?= $user['id'] ?>" onclick="return confirm('Изменить статус?')">
                <?= $user['is_blocked'] ? '🔓 Разблокировать' : '🔒 Заблокировать' ?>
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php include __DIR__ . '/../footer.php'; ?>