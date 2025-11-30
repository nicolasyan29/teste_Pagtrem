<?php
require_once __DIR__ . '/../config/db.php';
if (empty($_SESSION['user_id'])) header('Location: login.php');
$res = mysqli_query($conn, "SELECT * FROM rotas ORDER BY id DESC");
$rotas = mysqli_fetch_all($res, MYSQLI_ASSOC);
?>
<!doctype html><html><head><meta charset="utf-8"><title>Rotas</title><link rel="stylesheet" href="../assets/style.css"></head><body>
<div class="app-shell"><div class="card"><div style="display:flex;justify-content:space-between"><h3>Rotas</h3><a class="btn" href="novo_rota.php">+ Nova Rota</a></div>
<table class="table"><thead><tr><th>ID</th><th>Nome</th><th>Origem</th><th>Destino</th><th>Duração</th><th>Ações</th></tr></thead><tbody>
<?php foreach($rotas as $r): ?>
<tr><td><?php echo $r['id'];?></td><td><?php echo htmlspecialchars($r['nome']);?></td><td><?php echo htmlspecialchars($r['origem']);?></td><td><?php echo htmlspecialchars($r['destino']);?></td><td><?php echo htmlspecialchars($r['duracao_min']);?></td><td><a class="btn" href="editar_rota.php?id=<?php echo $r['id'];?>">Editar</a> <a class="btn" href="deletar_rota.php?id=<?php echo $r['id'];?>" onclick="return confirm('Confirmar?')">Deletar</a></td></tr>
<?php endforeach; ?>
</tbody></table></div></div></body></html>
