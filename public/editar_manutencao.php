<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$id = intval($_GET['id'] ?? 0);
if (!$id) header('Location: manutencoes.php');

$stmt = $pdo->prepare('SELECT * FROM manutencoes WHERE id = :id');
$stmt->execute([':id'=>$id]);
$m = $stmt->fetch();
if (!$m) header('Location: manutencoes.php');

$trens = $pdo->query('SELECT id, codigo FROM trens ORDER BY codigo')->fetchAll();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trem_id = intval($_POST['trem_id'] ?? 0);
    $descricao = trim($_POST['descricao'] ?? '');
    $data_prevista = $_POST['data_prevista'] ?? null;
    $concluido = isset($_POST['concluido']) ? 1 : 0;
    if (!$trem_id) $errors[] = 'Selecione um trem.';
    if ($descricao === '') $errors[] = 'Descrição obrigatória.';
    if (empty($errors)) {
        $upd = $pdo->prepare('UPDATE manutencoes SET trem_id=:tid, descricao=:d, data_prevista=:dp, concluido=:c WHERE id=:id');
        $upd->execute([':tid'=>$trem_id,':d'=>$descricao,':dp'=>$data_prevista ?: null,':c'=>$concluido,':id'=>$id]);
        header('Location: manutencoes.php'); exit;
    }
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Editar Manutenção</title><link rel="stylesheet" href="../assets/style.css"></head><body>
  <div class="app-shell">
    <div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="manutencoes.php">Voltar</a></div></div>
    <div class="card" style="max-width:720px;margin:auto">
      <h3>Editar Manutenção</h3>
      <?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
      <form method="post">
        <label>Trem
          <select name="trem_id" required>
            <option value="">-- selecione --</option>
            <?php foreach($trens as $t): ?><option value="<?php echo $t['id']; ?>" <?php if($t['id']==$m['trem_id']) echo 'selected'; ?>><?php echo htmlspecialchars($t['codigo']); ?></option><?php endforeach; ?>
          </select>
        </label>
        <label>Descrição<textarea name="descricao" rows="4"><?php echo htmlspecialchars($m['descricao']); ?></textarea></label>
        <label>Data Prevista<input type="date" name="data_prevista" value="<?php echo htmlspecialchars($m['data_prevista']); ?>"></label>
        <label><input type="checkbox" name="concluido" <?php if($m['concluido']) echo 'checked'; ?>> Concluído</label>
        <div style="margin-top:12px;display:flex;gap:10px"><button class="btn primary" type="submit">Salvar</button><a class="btn ghost" href="manutencoes.php">Cancelar</a></div>
      </form>
    </div>
  </div>
</body></html>
