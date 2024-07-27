<?php
require_once '../includes/db.php';
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: ../user/login.php');
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM posts WHERE id = ?");
$stmt->execute([$id]);

header('Location: index.php');
?>
