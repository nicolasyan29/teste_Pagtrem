<?php
require_once __DIR__ . '/../public/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
  $nome=trim($_POST['nome']??''); $origem=trim($_POST['origem']??''); $destino=trim($_POST['destino']??''); $dur=intval($_POST['duracao_min']??0); $ativo=isset($_POST['ativo'])?1:0;
  if($nome==='') $errors[]='Nome obrigatório';
  if(empty($errors)){ $st=mysqli_prepare($conn,"INSERT INTO rotas (nome,origem,destino,duracao_min,ativo) VALUES (?,?,?,?,?)"); mysqli_stmt_bind_param($st,"sssii",$nome,$origem,$destino,$dur,$ativo); mysqli_stmt_execute($st); header('Location: rotas.php'); exit;}
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Nova Rota</title><link rel="stylesheet" href="../assets/style.css"></head><body><div class="app-shell"><div class="card" style="max-width:720px;margin:auto"><h3>Nova Rota</h3><?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
<form method="post"><label>Nome<input type="text" name="nome"></label><label>Origem<input type="text" name="origem"></label><label>Destino<input type="text" name="destino"></label><label>Duração (min)<input type="number" name="duracao_min"></label><label><input type="checkbox" name="ativo" checked> Ativa</label><div style="margin-top:12px"><button class="btn primary" type="submit">Salvar</button> <a class="btn" href="rotas.php">Cancelar</a></div></form></div></div></body></html>
