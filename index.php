<?php
require_once 'includes/db.php';
session_start(); // добавляем старт сессии для проверки авторизации

$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Личный блог</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header>
        <h1>Личный блог</h1>
        <nav>
            <a href="index.php">Главная</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <?php
                // Получение имени пользователя из базы данных
                $stmt = $pdo->prepare("SELECT username FROM users WHERE id = ?");
                $stmt->execute([$_SESSION['user_id']]);
                $user = $stmt->fetch();
                ?>
                <span>Добро пожаловать, <?php echo htmlspecialchars($user['username']); ?>!</span>
                <a href="admin/index.php">Админка</a>
                <a href="user/logout.php">Выйти</a>
            <?php else: ?>
                <a href="user/login.php">Войти</a>
                <a href="user/register.php">Регистрация</a>
            <?php endif; ?>
        </nav>
    </header>

    <main>
        <ul>
            <?php foreach ($posts as $post): ?>
                <li>
                    <a href="posts/view_post.php?id=<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a>
                    <p><?php echo htmlspecialchars(substr($post['content'], 0, 100)); ?>...</p>
                </li>
            <?php endforeach; ?>
        </ul>
    </main>

    <footer>
        <p>&copy; <?php echo date('Y'); ?> Личный блог</p>
    </footer>
</body>
</html>
