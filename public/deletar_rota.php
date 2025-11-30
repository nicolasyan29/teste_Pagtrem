<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$id=intval($_GET['id']??0);
if($id){ $st=mysqli_prepare($conn,"DELETE FROM rotas WHERE id=?"); mysqli_stmt_bind_param($st,"i",$id); mysqli_stmt_execute($st); }
header('Location: rotas.php'); exit;
