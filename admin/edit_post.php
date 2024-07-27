<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit;
}

$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $pdo->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->execute([$title, $content, $id]);

    header('Location: index.php');
} else {
    $stmt = $pdo->prepare("SELECT * FROM posts WHERE id = ?");
    $stmt->execute([$id]);
    $post = $stmt->fetch();
}
?>

<form method="POST">
    <input type="text" name="title" value="<?php echo $post['title']; ?>" required>
    <textarea name="content" required><?php echo $post['content']; ?></textarea>
    <button type="submit">Обновить пост</button>
</form>
