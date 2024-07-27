<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $author_id = $_SESSION['user_id'];

    $stmt = $pdo->prepare("INSERT INTO posts (title, content, author_id) VALUES (?, ?, ?)");
    $stmt->execute([$title, $content, $author_id]);

    header('Location: index.php');
}
?>

<form method="POST">
    <input type="text" name="title" placeholder="Заголовок" required>
    <textarea name="content" placeholder="Содержание" required></textarea>
    <button type="submit">Создать пост</button>
</form>
