<?php
require_once __DIR__ . '/../config/db.php';

$err = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['senha'] ?? '';
    if ($user === '' || $pass === '') $err = 'Usuário e senha são obrigatórios.';
    else {
        $stmt = $pdo->prepare('SELECT * FROM usuarios WHERE username = :u LIMIT 1');
        $stmt->execute([':u'=>$user]);
        $u = $stmt->fetch();
        if ($u && password_verify($pass, $u['senha'])) {
            session_regenerate_id(true);
            $_SESSION['user_id'] = $u['id'];
            $_SESSION['username'] = $u['username'];
            $_SESSION['cargo'] = $u['cargo'];
            header('Location: index.php');
            exit;
        } else {
            $err = 'Usuário ou senha inválidos.';
        }
    }
}
?>
<!doctype html>
<html lang="pt-BR"><head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
  <title>Login - Ferrovia</title>
  <link rel="stylesheet" href="../assets/style.css">
</head><body>
  <div class="app-shell">
    <div class="header">
      <div class="brand">Ferrovia</div>
      <div class="topnav"><a href="index.php" class="btn">Voltar</a></div>
    </div>

    <div class="grid">
      <div class="card" style="max-width:520px;margin:auto;">
        <h2>Entrar</h2>
        <?php if ($err): ?><div class="alert"><?php echo htmlspecialchars($err); ?></div><?php endif; ?>
        <form method="post" autocomplete="off">
          <label>Usuário<input name="username" type="text" required></label>
          <label>Senha<input name="senha" type="password" required></label>
          <div style="display:flex;gap:10px;margin-top:12px">
            <button class="btn primary" type="submit">Entrar</button>
            <a class="btn ghost" href="index.php">Voltar</a>
          </div>
        </form>
        <div class="footer">Use <strong>admin / admin123</strong> (troque depois)</div>
      </div>
    </div>
  </div>
</body></html>
