<?php 
// Проверяем, авторизован ли пользователь
$isLoggedIn = isset($_SESSION['user_id']);
$userName = $isLoggedIn ? $_SESSION['user_name'] : '';
$userRole = $isLoggedIn ? $_SESSION['role'] : '';
?>

<?php include __DIR__ . '/../layout.php'; ?>

<!-- Блок приветствия -->
<div style="
    background: #007bff;
    border-radius: 20px;
    padding: 40px;
    margin-bottom: 30px;
    color: white;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0,0,0,0.3);
">
    <?php if ($isLoggedIn): ?>
        <h1 style="font-size: 36px; margin-bottom: 10px;">
            👋 С возвращением, <?= htmlspecialchars($userName) ?>!
        </h1>
        <p style="font-size: 18px; opacity: 0.9;">
            <?php if ($userRole == 'admin'): ?>
                🔐 Вы вошли как администратор. У вас есть полный доступ к системе.
            <?php elseif ($userRole == 'author'): ?>
                ✍️ Вы вошли как автор. Создавайте блоги и делитесь своими статьями!
            <?php else: ?>
                📖 Вы вошли как читатель. Читайте статьи и подписывайтесь на авторов!
            <?php endif; ?>
        </p>
    <?php else: ?>
        <h1 style="font-size: 45px; margin-bottom: 25px;">
            Добро пожаловать в BloGGing-CenteR
        </h1>
        <p style="font-size: 22px; margin-bottom: 35px; opacity: 0.95;">
            Платформа для ведения тематических блогов. Делитесь мыслями, читайте интересные статьи, общайтесь с единомышленниками.
        </p>
        <div style="display: flex; gap: 15px; justify-content: center;">
            <a href="<?= BASE_PATH ?>/?action=register" class="btn" style="background: white; color: #008cff; padding: 12px 30px; font-size: 16px;">
                📝 Регистрация
            </a>
            <a href="<?= BASE_PATH ?>/?action=login" class="btn" style="background: transparent; border: 2px solid white; padding: 12px 30px; font-size: 16px;">
                🔐 Вход
            </a>
        </div>
    <?php endif; ?>
</div>

<?php if ($isLoggedIn): ?>
    
    <!-- Для авторизованных пользователей - блок статистики -->
    <div style="display: flex; gap: 20px; flex-wrap: wrap; margin-bottom: 30px;">
        <div style="flex: 1; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 15px; padding: 20px; text-align: center; color: white;">
            <div style="font-size: 40px;">📚</div>
            <div style="font-size: 24px;">Читайте статьи</div>
            <div>и подписывайтесь на авторов!</div>
        </div>
        <div style="flex: 1; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); border-radius: 15px; padding: 20px; text-align: center; color: white;">
            <div style="font-size: 40px;">✍️</div>
            <div style="font-size: 24px;">Комментируйте</div>
            <div>и обсуждайте!</div>
        </div>
        <div style="flex: 1; background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); border-radius: 15px; padding: 20px; text-align: center; color: white;">
            <div style="font-size: 40px;">⭐</div>
            <div style="font-size: 24px;">Станьте автором</div>
            <div>и создавайте свои блоги!</div>
        </div>
    </div>
    
    <!-- Список статей -->
    <h1 style="margin-bottom: 20px;">📖 Все статьи</h1>
    
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-error"><?= htmlspecialchars($_SESSION['error']) ?></div>
        <?php unset($_SESSION['error']); ?>
    <?php endif; ?>

    <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= htmlspecialchars($_SESSION['success']) ?></div>
        <?php unset($_SESSION['success']); ?>
    <?php endif; ?>

    <?php if (empty($posts)): ?>
        <div class="post-card" style="text-align: center; padding: 40px;">
            <p style="font-size: 18px;">📭 Пока нет статей.</p>
            <?php if ($userRole == 'author'): ?>
                <a href="<?= BASE_PATH ?>/?action=create-post" class="btn btn-success" style="margin-top: 15px;">➕ Создать первую статью</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <?php foreach($posts as $post): ?>
            <div class="post-card">
                <h3><?= htmlspecialchars($post['title']) ?></h3>
                <p>
                    <small>
                        ✍️ Автор: <?= htmlspecialchars($post['author_name']) ?> | 
                        👁️ <?= $post['views_count'] ?> просмотров | 
                        📅 <?= $post['created_at'] ?>
                    </small>
                </p>
                <p><?= htmlspecialchars(mb_substr($post['content'], 0, 200)) ?>...</p>
                <a href="<?= BASE_PATH ?>/?action=view-post&id=<?= $post['id'] ?>" class="btn">Читать далее →</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    
<?php else: ?>
    
    <!-- Для гостей - показываем информацию о платформе -->
    <div style="display: flex; gap: 30px; flex-wrap: wrap; margin-top: 20px;">
        <div class="post-card" style="flex: 1; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 15px;">📝</div>
            <h3>Создавайте блоги</h3>
            <p>Зарегистрируйтесь и создайте свой собственный блог. Делитесь мыслями, идеями и опытом.</p>
        </div>
        
        <div class="post-card" style="flex: 1; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 15px;">📖</div>
            <h3>Читайте статьи</h3>
            <p>Откройте для себя множество интересных статей от авторов со всего мира.</p>
        </div>
        
        <div class="post-card" style="flex: 1; text-align: center;">
            <div style="font-size: 48px; margin-bottom: 15px;">💬</div>
            <h3>Общайтесь</h3>
            <p>Комментируйте статьи, обсуждайте темы, находите единомышленников.</p>
        </div>
    </div>
    
    <!-- Показать несколько последних статей для гостей -->
    <?php if (!empty($posts)): ?>
        <h2 style="margin: 30px 0 20px;">⭐ Популярные статьи</h2>
        <?php 
        $recentPosts = array_slice($posts, 0, 3);
        foreach($recentPosts as $post): ?>
            <div class="post-card">
                <h3><?= htmlspecialchars($post['title']) ?></h3>
                <p>
                    <small>
                        ✍️ Автор: <?= htmlspecialchars($post['author_name']) ?> | 
                        👁️ <?= $post['views_count'] ?> просмотров
                    </small>
                </p>
                <p><?= htmlspecialchars(mb_substr($post['content'], 0, 150)) ?>...</p>
                <a href="<?= BASE_PATH ?>/?action=view-post&id=<?= $post['id'] ?>" class="btn">Читать далее →</a>
            </div>
        <?php endforeach; ?>
        
        <div style="text-align: center; margin-top: 20px;">
            <a href="<?= BASE_PATH ?>/?action=register" class="btn btn-success" style="padding: 12px 30px;">
                📝 Зарегистрироваться, чтобы читать все статьи
            </a>
        </div>
    <?php endif; ?>
    
<?php endif; ?>

<?php include __DIR__ . '/../footer.php'; ?>