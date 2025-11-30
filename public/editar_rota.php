<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$id=intval($_GET['id']??0); if(!$id) header('Location: rotas.php');
$st=mysqli_prepare($conn,"SELECT * FROM rotas WHERE id=?"); mysqli_stmt_bind_param($st,"i",$id); mysqli_stmt_execute($st); $res=mysqli_stmt_get_result($st); $r=mysqli_fetch_assoc($res);
if(!$r) header('Location: rotas.php');
$errors=[];
if($_SERVER['REQUEST_METHOD']==='POST'){ $nome=trim($_POST['nome']??''); $origem=trim($_POST['origem']??''); $destino=trim($_POST['destino']??''); $dur=intval($_POST['duracao_min']??0); $ativo=isset($_POST['ativo'])?1:0; if($nome==='') $errors[]='Nome obrigatório'; if(empty($errors)){ $u=mysqli_prepare($conn,"UPDATE rotas SET nome=?,origem=?,destino=?,duracao_min=?,ativo=? WHERE id=?"); mysqli_stmt_bind_param($u,"sssiii",$nome,$origem,$destino,$dur,$ativo,$id); mysqli_stmt_execute($u); header('Location: rotas.php'); exit; } }
?>
<!doctype html><html><head><meta charset="utf-8"><title>Editar Rota</title><link rel="stylesheet" href="../assets/style.css"></head><body><div class="app-shell"><div class="card" style="max-width:720px;margin:auto"><h3>Editar Rota</h3><?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
<form method="post"><label>Nome<input type="text" name="nome" value="<?php echo htmlspecialchars($r['nome']);?>"></label><label>Origem<input type="text" name="origem" value="<?php echo htmlspecialchars($r['origem']);?>"></label><label>Destino<input type="text" name="destino" value="<?php echo htmlspecialchars($r['destino']);?>"></label><label>Duração (min)<input type="number" name="duracao_min" value="<?php echo htmlspecialchars($r['duracao_min']);?>"></label><label><input type="checkbox" name="ativo" <?php if($r['ativo']) echo 'checked'; ?>> Ativa</label><div style="margin-top:12px"><button class="btn primary" type="submit">Salvar</button> <a class="btn" href="rotas.php">Cancelar</a></div></form></div></div></body></html>
