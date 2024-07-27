<?php
require_once '../includes/db.php';
session_start();

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->execute([$id]);
$post = $stmt->fetch();

$comments_stmt = $pdo->prepare("SELECT * FROM comments WHERE post_id = ? ORDER BY created_at DESC");
$comments_stmt->execute([$id]);
$comments = $comments_stmt->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $content = $_POST['content'];
    $user_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO comments (post_id, user_id, content) VALUES (?, ?, ?)");
    $stmt->execute([$id, $user_id, $content]);

    header("Location: view_post.php?id=$id");
}
?>

<h1><?php echo $post['title']; ?></h1>
<p><?php echo $post['content']; ?></p>

<h2>Комментарии</h2>
<ul>
    <?php foreach ($comments as $comment): ?>
        <li><?php echo $comment['content']; ?> (<?php echo $comment['created_at']; ?>)</li>
    <?php endforeach; ?>
</ul>

<?php if (isset($_SESSION['user_id'])): ?>
    <form method="POST">
        <textarea name="content" required></textarea>
        <button type="submit">Добавить комментарий</button>
    </form>
<?php else: ?>
    <p><a href="../user/login.php">Войдите</a>, чтобы оставить комментарий.</p>
<?php endif; ?>
