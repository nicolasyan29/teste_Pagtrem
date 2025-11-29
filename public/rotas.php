<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$rotas = $pdo->query('SELECT * FROM rotas ORDER BY id DESC')->fetchAll();
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Rotas</title><link rel="stylesheet" href="../assets/style.css"></head><body>
  <div class="app-shell">
    <div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="index.php">Voltar</a></div></div>
    <div class="card">
      <div style="display:flex;justify-content:space-between;align-items:center">
        <h3>Rotas</h3>
        <a class="btn" href="novo_rota.php">+ Nova Rota</a>
      </div>
      <table class="table"><thead><tr><th>ID</th><th>Nome</th><th>Origem</th><th>Destino</th><th>Duração (min)</th><th>Ativa</th><th>Ações</th></tr></thead><tbody>
        <?php foreach($rotas as $r): ?>
        <tr>
          <td><?php echo $r['id']; ?></td>
          <td><?php echo htmlspecialchars($r['nome']); ?></td>
          <td><?php echo htmlspecialchars($r['origem']); ?></td>
          <td><?php echo htmlspecialchars($r['destino']); ?></td>
          <td><?php echo htmlspecialchars($r['duracao_min']); ?></td>
          <td><?php echo $r['ativo'] ? 'Sim' : 'Não'; ?></td>
          <td><a class="action" href="editar_rota.php?id=<?php echo $r['id']; ?>">Editar</a> <a class="action danger" href="deletar_rota.php?id=<?php echo $r['id']; ?>" onclick="return confirm('Confirmar?')">Deletar</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody></table>
    </div>
  </div>
</body></html>
