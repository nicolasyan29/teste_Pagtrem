<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');

$stmt = $pdo->query("SELECT m.*, t.codigo AS trem_codigo FROM manutencoes m LEFT JOIN trens t ON t.id = m.trem_id ORDER BY m.id DESC");
$manuts = $stmt->fetchAll();
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Manutenções</title><link rel="stylesheet" href="../assets/style.css"></head><body>
  <div class="app-shell">
    <div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="index.php">Voltar</a></div></div>
    <div class="card">
      <div style="display:flex;justify-content:space-between;align-items:center">
        <h3>Manutenções</h3>
        <a class="btn" href="novo_manutencao.php">+ Nova</a>
      </div>
      <table class="table"><thead><tr><th>ID</th><th>Trem</th><th>Descrição</th><th>Data Prevista</th><th>Concluído</th><th>Ações</th></tr></thead><tbody>
        <?php foreach($manuts as $m): ?>
        <tr>
          <td><?php echo $m['id']; ?></td>
          <td><?php echo htmlspecialchars($m['trem_codigo']); ?></td>
          <td><?php echo htmlspecialchars($m['descricao']); ?></td>
          <td><?php echo htmlspecialchars($m['data_prevista']); ?></td>
          <td><?php echo $m['concluido'] ? 'Sim' : 'Não'; ?></td>
          <td><a class="action" href="editar_manutencao.php?id=<?php echo $m['id']; ?>">Editar</a> <a class="action danger" href="deletar_manutencao.php?id=<?php echo $m['id']; ?>" onclick="return confirm('Confirmar?')">Deletar</a></td>
        </tr>
        <?php endforeach; ?>
      </tbody></table>
    </div>
  </div>
</body></html>
