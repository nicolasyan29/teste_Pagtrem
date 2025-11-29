<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$id = intval($_GET['id'] ?? 0);
if (!$id) header('Location: rotas.php');

$stmt = $pdo->prepare('SELECT * FROM rotas WHERE id = :id');
$stmt->execute([':id'=>$id]);
$r = $stmt->fetch();
if (!$r) header('Location: rotas.php');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $origem = trim($_POST['origem'] ?? '');
    $destino = trim($_POST['destino'] ?? '');
    $duracao = intval($_POST['duracao_min'] ?? 0);
    $ativo = isset($_POST['ativo']) ? 1 : 0;
    if ($nome === '') $errors[] = 'Nome é obrigatório.';
    if (empty($errors)) {
        $upd = $pdo->prepare('UPDATE rotas SET nome=:n, origem=:o, destino=:d, duracao_min=:dur, ativo=:a WHERE id=:id');
        $upd->execute([':n'=>$nome,':o'=>$origem,':d'=>$destino,':dur'=>$duracao,':a'=>$ativo,':id'=>$id]);
        header('Location: rotas.php'); exit;
    }
}
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Editar Rota</title><link rel="stylesheet" href="../assets/style.css"></head><body>
  <div class="app-shell"><div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="rotas.php">Voltar</a></div></div>
  <div class="card" style="max-width:720px;margin:auto">
    <h3>Editar Rota</h3>
    <?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
    <form method="post">
      <label>Nome<input type="text" name="nome" required value="<?php echo htmlspecialchars($r['nome']); ?>"></label>
      <label>Origem<input type="text" name="origem" value="<?php echo htmlspecialchars($r['origem']); ?>"></label>
      <label>Destino<input type="text" name="destino" value="<?php echo htmlspecialchars($r['destino']); ?>"></label>
      <label>Duração (min)<input type="number" name="duracao_min" value="<?php echo htmlspecialchars($r['duracao_min']); ?>"></label>
      <label><input type="checkbox" name="ativo" <?php if($r['ativo']) echo 'checked'; ?>> Ativa</label>
      <div style="margin-top:12px;display:flex;gap:10px"><button class="btn primary" type="submit">Salvar</button><a class="btn ghost" href="rotas.php">Cancelar</a></div>
    </form>
  </div></div>
</body></html>
