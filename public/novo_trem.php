<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$errors=[];
if ($_SERVER['REQUEST_METHOD']==='POST') {
    $codigo = trim($_POST['codigo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $cap = intval($_POST['capacidade'] ?? 0);
    $status = $_POST['status'] ?? 'operacional';
    if ($codigo==='') $errors[]='Código obrigatório.';
    if (empty($errors)) {
        $st = mysqli_prepare($conn,"INSERT INTO trens (codigo,descricao,capacidade,status) VALUES (?,?,?,?)");
        mysqli_stmt_bind_param($st,"ssis",$codigo,$descricao,$cap,$status);
        mysqli_stmt_execute($st);
        header('Location: trens.php'); exit;
    }
}
?>
<!doctype html><html><head><meta charset="utf-8"><title>Novo Trem</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="app-shell">
  <div class="card" style="max-width:720px;margin:auto">
    <h3>Novo Trem</h3>
    <?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
    <form method="post">
      <label>Código<input type="text" name="codigo"></label>
      <label>Descrição<input type="text" name="descricao"></label>
      <label>Capacidade<input type="number" name="capacidade" value="0"></label>
      <label>Status<select name="status"><option value="operacional">Operacional</option><option value="manutencao">Manutenção</option><option value="inativo">Inativo</option></select></label>
      <div style="margin-top:12px"><button class="btn primary" type="submit">Salvar</button> <a class="btn" href="trens.php">Cancelar</a></div>
    </form>
  </div>
</div>
</body></html>
