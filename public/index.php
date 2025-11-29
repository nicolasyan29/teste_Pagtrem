<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');

$q = trim($_GET['q'] ?? '');
$sql = "SELECT * FROM funcionarios";
$params = [];
if ($q !== '') {
    $sql .= " WHERE nome LIKE :q OR cpf LIKE :q OR cargo LIKE :q OR email LIKE :q OR cidade LIKE :q OR cep LIKE :q";
    $params[':q'] = "%$q%";
}
$sql .= " ORDER BY id DESC LIMIT 200";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$funcionarios = $stmt->fetchAll();
?>
<!doctype html>
<html lang="pt-BR"><head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Dashboard - Ferrovia</title>
  <link rel="stylesheet" href="../assets/style.css">
</head><body>
  <div class="app-shell">
    <div class="header">
      <div class="brand">Ferrovia — Dashboard</div>
      <div class="topnav">
        <a href="index.php" class="btn">Funcionários</a>
        <a href="trens.php" class="btn">Trens</a>
        <a href="rotas.php" class="btn">Rotas</a>
        <a href="manutencoes.php" class="btn">Manutenções</a>
        <a href="logout.php" class="btn ghost">Sair (<?php echo htmlspecialchars($_SESSION['username']); ?>)</a>
      </div>
    </div>

    <div class="grid">
      <div class="card">
        <div style="display:flex;justify-content:space-between;align-items:center">
          <h3>Funcionários</h3>
          <div class="controls">
            <a class="btn" href="novo_funcionario.php">+ Novo</a>
            <input id="searchInput" class="search-field" placeholder="Buscar por nome, CEP ou cidade" value="<?php echo htmlspecialchars($q); ?>">
          </div>
        </div>

        <table class="table" aria-live="polite">
          <thead>
            <tr><th>ID</th><th>Nome</th><th>Cargo</th><th>E-mail</th><th>CEP</th><th>Cidade</th><th>Ações</th></tr>
          </thead>
          <tbody>
            <?php foreach($funcionarios as $f): ?>
            <tr>
              <td><?php echo $f['id']; ?></td>
              <td><?php echo htmlspecialchars($f['nome']); ?></td>
              <td><?php echo htmlspecialchars($f['cargo']); ?></td>
              <td><?php echo htmlspecialchars($f['email']); ?></td>
              <td><?php echo htmlspecialchars($f['cep']); ?></td>
              <td><?php echo htmlspecialchars($f['cidade']); ?></td>
              <td>
                <a class="action" href="editar_funcionario.php?id=<?php echo $f['id']; ?>">Editar</a>
                <a class="action danger" href="deletar_funcionario.php?id=<?php echo $f['id']; ?>" onclick="return confirm('Confirmar exclusão?')">Deletar</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>

      <aside class="card">
        <h4>Resumo</h4>
        <p class="kv">Total de funcionários: <?php echo count($funcionarios); ?></p>
        <hr>
        <p class="kv">Acesso: <?php echo htmlspecialchars($_SESSION['username']); ?> (<?php echo htmlspecialchars($_SESSION['cargo']); ?>)</p>
      </aside>
    </div>

    <div class="footer">Sistema Ferrovia • Gerado por você</div>
  </div>

  <script src="../assets/app.js"></script>
</body></html>
