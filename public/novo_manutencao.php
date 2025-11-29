<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');

$trens = $pdo->query('SELECT id, codigo FROM trens ORDER BY codigo')->fetchAll();
$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $trem_id = intval($_POST['trem_id'] ?? 0);
    $descricao = trim($_POST['descricao'] ?? '');
    $data_prevista = $_POST['data_prevista'] ?? null;
    if (!$trem_id) $errors[] = 'Selecione um trem.';
    if ($descricao === '') $errors[] = 'Descrição obrigatória.';
    if (empty($errors)) {
        $stmt = $pdo->prepare('INSERT INTO manutencoes (trem_id, descricao, data_prevista) VALUES (:tid,:d,:dp)');
        $stmt->execute([':tid'=>$trem_id,':d'=>$descricao,':dp'=>$data_prevista ?: null]);
        header('Location: manutencoes.php'); exit;
    }
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Nova Manutenção</title><link rel="stylesheet" href="../assets/style.css"></head><body>
  <div class="app-shell">
    <div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="manutencoes.php">Voltar</a></div></div>
    <div class="card" style="max-width:720px;margin:auto">
      <h3>Nova Manutenção</h3>
      <?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
      <form method="post">
        <label>Trem
          <select name="trem_id" required>
            <option value="">-- selecione --</option>
            <?php foreach($trens as $t): ?><option value="<?php echo $t['id']; ?>"><?php echo htmlspecialchars($t['codigo']); ?></option><?php endforeach; ?>
          </select>
        </label>
        <label>Descrição<textarea name="descricao" rows="4"></textarea></label>
        <label>Data Prevista<input type="date" name="data_prevista"></label>
        <div style="margin-top:12px;display:flex;gap:10px"><button class="btn primary" type="submit">Salvar</button><a class="btn ghost" href="manutencoes.php">Cancelar</a></div>
      </form>
    </div>
  </div>
</body></html>
