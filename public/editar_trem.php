<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$id=intval($_GET['id']??0); if(!$id) header('Location: trens.php');
$st = mysqli_prepare($conn,"SELECT * FROM trens WHERE id=?"); mysqli_stmt_bind_param($st,"i",$id); mysqli_stmt_execute($st); $res = mysqli_stmt_get_result($st); $t = mysqli_fetch_assoc($res);
if(!$t) header('Location: trens.php');
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){
    $codigo=trim($_POST['codigo']??''); $descricao=trim($_POST['descricao']??''); $cap=intval($_POST['capacidade']??0); $status=$_POST['status']??'operacional';
    if($codigo==='') $errors[]='Código obrigatório.';
    if(empty($errors)){ $u = mysqli_prepare($conn,"UPDATE trens SET codigo=?, descricao=?, capacidade=?, status=? WHERE id=?"); mysqli_stmt_bind_param($u,"ssisi",$codigo,$descricao,$cap,$status,$id); mysqli_stmt_execute($u); header('Location: trens.php'); exit; }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Editar Trem</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="app-shell"><div class="card" style="max-width:720px;margin:auto"><h3>Editar Trem</h3><?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
<form method="post">
<label>Código<input type="text" name="codigo" value="<?php echo htmlspecialchars($t['codigo']); ?>"></label>
<label>Descrição<input type="text" name="descricao" value="<?php echo htmlspecialchars($t['descricao']); ?>"></label>
<label>Capacidade<input type="number" name="capacidade" value="<?php echo htmlspecialchars($t['capacidade']); ?>"></label>
<label>Status<select name="status"><option value="operacional" <?php if($t['status']=='operacional') echo 'selected'; ?>>Operacional</option><option value="manutencao" <?php if($t['status']=='manutencao') echo 'selected'; ?>>Manutenção</option><option value="inativo" <?php if($t['status']=='inativo') echo 'selected'; ?>>Inativo</option></select></label>
<div style="margin-top:12px"><button class="btn primary" type="submit">Salvar</button> <a class="btn" href="trens.php">Cancelar</a></div>
</form></div></div></body></html>
