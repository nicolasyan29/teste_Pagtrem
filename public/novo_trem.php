<?php
require_once __DIR__ . 'db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$errors=[];
$codigo = '';
$descricao = '';
$cap = 0;
$status = 'operacional';
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
  <div class="app-header" style="max-width:980px;margin:auto">
    <a class="logo" href="index.php">Pagtrem</a>
    <nav>
      <a href="trens.php">Trens</a>
      <a href="rotas.php">Rotas</a>
      <a href="funcionarios.php">Funcionários</a>
      <a href="logout.php">Sair</a>
    </nav>
  </div>
  <div class="card" style="max-width:720px;margin:18px auto">
    <h3>Novo Trem</h3>
    <?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
    <form method="post">
      <label>Código<input type="text" name="codigo" value="<?php echo htmlspecialchars($codigo); ?>"></label>
      <label>Descrição<input type="text" name="descricao" value="<?php echo htmlspecialchars($descricao); ?>"></label>
      <label>Capacidade<input type="number" name="capacidade" value="<?php echo htmlspecialchars($cap); ?>"></label>
      <label>Status<select name="status"><option value="operacional" <?php if($status=='operacional') echo 'selected'; ?>>Operacional</option><option value="manutencao" <?php if($status=='manutencao') echo 'selected'; ?>>Manutenção</option><option value="inativo" <?php if($status=='inativo') echo 'selected'; ?>>Inativo</option></select></label>
      <div style="margin-top:12px"><button class="btn primary" type="submit">Salvar</button> <a class="btn" href="trens.php">Cancelar</a></div>
    </form>
  </div>
</div>
</body></html>
