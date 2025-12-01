<?php
require_once __DIR__ . '/../public/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$res = mysqli_query($conn, "SELECT * FROM funcionarios ORDER BY id DESC");
$funcionarios = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Funcionários</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="app-shell">
  <div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="index.php">Voltar</a></div></div>
  <div class="card">
    <div style="display:flex;justify-content:space-between">
      <h3>Funcionários</h3>
      <a class="btn" href="novo_funcionario.php">+ Novo</a>
    </div>
    <table class="table"><thead><tr><th>ID</th><th>Nome</th><th>Cargo</th><th>Telefone</th><th>Cidade</th><th>Ações</th></tr></thead><tbody>
      <?php foreach($funcionarios as $f): ?>
      <tr>
        <td><?php echo $f['id']; ?></td>
        <td><?php echo htmlspecialchars($f['nome']); ?></td>
        <td><?php echo htmlspecialchars($f['cargo']); ?></td>
        <td><?php echo htmlspecialchars($f['telefone']); ?></td>
        <td><?php echo htmlspecialchars($f['cidade']); ?></td>
        <td>
          <a class="btn" href="editar_funcionario.php?id=<?php echo $f['id']; ?>">Editar</a>
          <a class="btn" href="deletar_funcionario.php?id=<?php echo $f['id']; ?>" onclick="return confirm('Confirmar?')">Deletar</a>
        </td>
      </tr>
      <?php endforeach; ?>
    </tbody></table>
  </div>
</div>
</body></html>
