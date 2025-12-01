<?php
require_once __DIR__ . '/../public/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$res = mysqli_query($conn, "SELECT * FROM trens ORDER BY id DESC");
$trens = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Trens</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="app-shell">
  <div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="index.php">Voltar</a></div></div>
  <div class="card">
    <div style="display:flex;justify-content:space-between;align-items:center">
      <h3>Trens</h3>
      <a class="btn" href="novo_trem.php">+ Novo Trem</a>
    </div>
    <table class="table"><thead><tr><th>ID</th><th>Código</th><th>Descrição</th><th>Capacidade</th><th>Status</th><th>Ações</th></tr></thead><tbody>
      <?php foreach($trens as $t): ?>
      <tr>
        <td><?php echo $t['id']; ?></td>
        <td><?php echo htmlspecialchars($t['codigo']); ?></td>
        <td><?php echo htmlspecialchars($t['descricao']); ?></td>
        <td><?php echo $t['capacidade']; ?></td>
        <td><?php echo $t['status']; ?></td>
        <td>
          <a class="btn" href="editar_trem.php?id=<?php echo $t['id']; ?>">Editar</a>
          <a class="btn" href="deletar_trem.php?id=<?php echo $t['id']; ?>" onclick="return confirm('Confirmar?')">Deletar</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody></table>
  </div>
</div>
</body></html>
