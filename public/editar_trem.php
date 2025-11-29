<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$id = intval($_GET['id'] ?? 0);
if (!$id) header('Location: trens.php');

$stmt = $pdo->prepare('SELECT * FROM trens WHERE id = :id');
$stmt->execute([':id'=>$id]);
$t = $stmt->fetch();
if (!$t) header('Location: trens.php');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = trim($_POST['codigo'] ?? '');
    $descricao = trim($_POST['descricao'] ?? '');
    $cap = intval($_POST['capacidade'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['operacional','manutencao','inativo']) ? $_POST['status'] : 'operacional';
    if ($codigo === '') $errors[] = 'Código é obrigatório.';
    if (empty($errors)) {
        $upd = $pdo->prepare('UPDATE trens SET codigo=:c, descricao=:d, capacidade=:cap, status=:s WHERE id=:id');
        $upd->execute([':c'=>$codigo,':d'=>$descricao,':cap'=>$cap,':s'=>$status,':id'=>$id]);
        header('Location: trens.php'); exit;
    }
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Editar Trem</title><link rel="stylesheet" href="../assets/style.css"></head><body>
  <div class="app-shell"><div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="trens.php">Voltar</a></div></div>
  <div class="card" style="max-width:720px;margin:auto">
    <h3>Editar Trem</h3>
    <?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
    <form method="post">
      <label>Código<input type="text" name="codigo" required value="<?php echo htmlspecialchars($t['codigo']); ?>"></label>
      <label>Descrição<input type="text" name="descricao" value="<?php echo htmlspecialchars($t['descricao']); ?>"></label>
      <label>Capacidade<input type="number" name="capacidade" value="<?php echo htmlspecialchars($t['capacidade']); ?>"></label>
      <label>Status<select name="status"><option value="operacional" <?php if($t['status']=='operacional') echo 'selected'; ?>>Operacional</option><option value="manutencao" <?php if($t['status']=='manutencao') echo 'selected'; ?>>Manutenção</option><option value="inativo" <?php if($t['status']=='inativo') echo 'selected'; ?>>Inativo</option></select></label>
      <div style="margin-top:12px;display:flex;gap:10px"><button class="btn primary" type="submit">Salvar</button><a class="btn ghost" href="trens.php">Cancelar</a></div>
    </form>
  </div></div>
</body></html>
