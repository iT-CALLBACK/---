<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM posts WHERE author_id = ?");
$stmt->execute([$_SESSION['user_id']]);
$posts = $stmt->fetchAll();
?>

<a href="create_post.php">Создать новый пост</a>

<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <a href="edit_post.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a>
            <a href="delete_post.php?id=<?php echo $post['id']; ?>">Удалить</a>
        </li>
    <?php endforeach; ?>
</ul>
