<?php
require_once __DIR__ . '/../config/db.php';
require_once __DIR__ . '/../lib/cep_lookup.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');

$id = intval($_GET['id'] ?? 0);
if (!$id) header('Location: index.php');

$stmt = $pdo->prepare('SELECT * FROM funcionarios WHERE id = :id');
$stmt->execute([':id'=>$id]);
$f = $stmt->fetch();
if (!$f) header('Location: index.php');

$errors = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome = trim($_POST['nome'] ?? '');
    $cpf = trim($_POST['cpf'] ?? '');
    $cargo = trim($_POST['cargo'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $telefone = trim($_POST['telefone'] ?? '');
    $cep = preg_replace('/\D/','', $_POST['cep'] ?? '');
    $rua = trim($_POST['rua'] ?? '');
    $bairro = trim($_POST['bairro'] ?? '');
    $cidade = trim($_POST['cidade'] ?? '');
    $estado = trim($_POST['estado'] ?? '');

    if ($nome === '') $errors[] = 'Nome é obrigatório.';

    if ($cep !== '') {
        $info = buscar_cep_servidor($cep);
        if ($info === false) $errors[] = 'CEP inválido ou não encontrado.';
        else {
            $rua = $info['rua'] ?: $rua;
            $bairro = $info['bairro'] ?: $bairro;
            $cidade = $info['cidade'] ?: $cidade;
            $estado = $info['estado'] ?: $estado;
        }
    }

    if (empty($errors)) {
        $local = ($rua ? $rua . ' - ' : '') . ($cidade ?: '') . ($estado ? ' /'.$estado : '');
        $upd = $pdo->prepare('UPDATE funcionarios SET nome=:nome, cpf=:cpf, cargo=:cargo, email=:email, telefone=:telefone, cep=:cep, rua=:rua, bairro=:bairro, cidade=:cidade, estado=:estado, localizacao=:local WHERE id=:id');
        $upd->execute([':nome'=>$nome,':cpf'=>$cpf,':cargo'=>$cargo,':email'=>$email,':telefone'=>$telefone,':cep'=>$cep,':rua'=>$rua,':bairro'=>$bairro,':cidade'=>$cidade,':estado'=>$estado,':local'=>$local,':id'=>$id]);
        header('Location: index.php'); exit;
    }
} else {
    // prefill form
    $_POST = array_merge($_POST, $f);
}
?>
<!doctype html>
<html lang="pt-BR"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Editar Funcionário</title><link rel="stylesheet" href="../assets/style.css"></head><body>
  <div class="app-shell">
    <div class="header"><div class="brand">Ferrovia</div><div class="topnav"><a class="btn" href="index.php">Voltar</a></div></div>
    <div class="card" style="max-width:780px;margin:auto">
      <h3>Editar Funcionário</h3>
      <?php if(!empty($errors)) foreach($errors as $e) echo "<div class='alert'>".htmlspecialchars($e)."</div>"; ?>
      <form method="post" novalidate>
        <div class="form-row">
          <div>
            <label>Nome<input type="text" name="nome" required value="<?php echo htmlspecialchars($_POST['nome'] ?? ''); ?>"></label>
            <label>CPF<input type="text" name="cpf" value="<?php echo htmlspecialchars($_POST['cpf'] ?? ''); ?>"></label>
            <label>Cargo<input type="text" name="cargo" value="<?php echo htmlspecialchars($_POST['cargo'] ?? ''); ?>"></label>
            <label>E-mail<input type="email" name="email" value="<?php echo htmlspecialchars($_POST['email'] ?? ''); ?>"></label>
            <label>Telefone<input type="text" name="telefone" value="<?php echo htmlspecialchars($_POST['telefone'] ?? ''); ?>"></label>
          </div>
          <div>
            <label>CEP<input id="cep" type="text" name="cep" maxlength="8" value="<?php echo htmlspecialchars($_POST['cep'] ?? ''); ?>"></label>
            <label>Rua<input id="rua" type="text" name="rua" readonly value="<?php echo htmlspecialchars($_POST['rua'] ?? ''); ?>"></label>
            <label>Bairro<input id="bairro" type="text" name="bairro" readonly value="<?php echo htmlspecialchars($_POST['bairro'] ?? ''); ?>"></label>
            <label>Cidade<input id="cidade" type="text" name="cidade" readonly value="<?php echo htmlspecialchars($_POST['cidade'] ?? ''); ?>"></label>
            <label>Estado<input id="estado" type="text" name="estado" readonly value="<?php echo htmlspecialchars($_POST['estado'] ?? ''); ?>"></label>
          </div>
        </div>

        <div style="margin-top:12px;display:flex;gap:10px">
          <button class="btn primary" type="submit">Salvar</button>
          <a class="btn ghost" href="index.php">Cancelar</a>
        </div>
      </form>
    </div>
  </div>

  <script src="../assets/cep.js"></script>
</body></html>
