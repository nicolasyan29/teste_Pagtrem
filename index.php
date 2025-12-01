
<?php
require_once __DIR__ . '/../public/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');

$q = trim($_GET['q'] ?? '');
$params = [];
$sql = "SELECT * FROM funcionarios";
if ($q !== '') {
    $sql .= " WHERE nome LIKE ? OR cpf LIKE ? OR cidade LIKE ? OR cep LIKE ?";
    $like = "%$q%";
    $params = [$like,$like,$like,$like];
}
$sql .= " ORDER BY id DESC LIMIT 200";
$stmt = mysqli_prepare($conn, $sql);
if ($params) {
    mysqli_stmt_bind_param($stmt, str_repeat('s', count($params)), ...$params);
}
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$funcionarios = $res ? mysqli_fetch_all($res, MYSQLI_ASSOC) : [];
?>
<!doctype html><html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Dashboard - Ferrovia</title><link rel="stylesheet" href="../assets/style.css"></head><body>
  <div class="app-shell">
    <div class="header">
      <div class="brand">Ferrovia — Dashboard</div>
      <div class="topnav">
        <a class="btn" href="funcionarios.php">Funcionários</a>
        <a class="btn" href="trens.php">Trens</a>
        <a class="btn" href="rotas.php">Rotas</a>
        <a class="btn" href="logout.php">Sair (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
      </div>
    </div>

    <div class="card">
      <div style="display:flex;justify-content:space-between;align-items:center">
        <h3>Funcionários</h3>
        <div>
          <a class="btn" href="novo_funcionario.php">+ Novo</a>
          <input id="searchInput" class="search-field" placeholder="Buscar por nome/CEP/cidade" value="<?php echo htmlspecialchars($q); ?>">
        </div>
      </div>

      <table class="table"><thead><tr><th>ID</th><th>Nome</th><th>Cargo</th><th>E-mail</th><th>CEP</th><th>Cidade</th><th>Ações</th></tr></thead><tbody>
        <?php foreach($funcionarios as $f): ?>
        <tr>
          <td><?php echo $f['id']; ?></td>
          <td><?php echo htmlspecialchars($f['nome']); ?></td>
          <td><?php echo htmlspecialchars($f['cargo']); ?></td>
          <td><?php echo htmlspecialchars($f['email']); ?></td>
          <td><?php echo htmlspecialchars($f['cep']); ?></td>
          <td><?php echo htmlspecialchars($f['cidade']); ?></td>
          <td>
            <a class="btn" href="editar_funcionario.php?id=<?php echo $f['id']; ?>">Editar</a>
            <a class="btn" href="deletar_funcionario.php?id=<?php echo $f['id']; ?>" onclick="return confirm('Confirmar exclusão?')">Deletar</a>
          </td>
        </tr>
        <?php endforeach; ?>
      </tbody></table>
    </div>
  </div>
<script src="../assets/app.js"></script>
</body></html>
