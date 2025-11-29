<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$id = intval($_GET['id'] ?? 0);
if ($id) {
    $stmt = $pdo->prepare('DELETE FROM rotas WHERE id = :id');
    $stmt->execute([':id'=>$id]);
}
header('Location: rotas.php'); exit;
