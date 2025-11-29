<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = trim($_POST['codigo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $cap = intval($_POST['capacidade'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['operacional','manutencao','inativo']) ? $_POST['status'] : 'operacional';
    if ($codigo === '') $errors[] = 'Código é obrigatório.';
    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO trens (codigo, descricao, capacidade, status) VALUES (:c,:d,:cap,:s)');
        $stmt->execute([':c'=>$codigo,':d'=>$descricao,':cap'=>$cap,':s'=>$status]);
        header('Location: trens.php'); exit;
    }
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Novo Trem</title><link rel="stylesheet" href="../assets/style.css"></head><body>
  <div class="app-shell"><div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="trens.php">Voltar</a></div></div>
  <div class="card" style="max-width:720px;margin:auto">
    <h3>Novo Trem</h3>
    <?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
    <form method="post">
      <label>Código<input type="text" name="codigo" required value="<?php echo htmlspecialchars($_POST['codigo'] ?? ''); ?>"></label>
      <label>Descrição<input type="text" name="descricao" value="<?php echo htmlspecialchars($_POST['descricao'] ?? ''); ?>"></label>
      <label>Capacidade<input type="number" name="capacidade" value="<?php echo htmlspecialchars($_POST['capacidade'] ?? ''); ?>"></label>
      <label>Status<select name="status"><option value="operacional">Operacional</option><option value="manutencao">Manutenção</option><option value="inativo">Inativo</option></select></label>
      <div style="margin-top:12px;display:flex;gap:10px"><button class="btn primary" type="submit">Salvar</button><a class="btn ghost" href="trens.php">Cancelar</a></div>
    </form>
  </div></div>
</body></html>
