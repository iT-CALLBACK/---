<?php
require_once '../includes/db.php';

$stmt = $pdo->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts = $stmt->fetchAll();
?>

<ul>
    <?php foreach ($posts as $post): ?>
        <li>
            <a href="view_post.php?id=<?php echo $post['id']; ?>"><?php echo $post['title']; ?></a>
            <p><?php echo substr($post['content'], 0, 100); ?>...</p>
        </li>
    <?php endforeach; ?>
</ul>
