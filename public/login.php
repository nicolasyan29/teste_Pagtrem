
<?php
session_start();
if($_SERVER['REQUEST_METHOD']==='POST'){
    include '../config/db.php';
    $u=$_POST['usuario'];
    $s=$_POST['senha'];
    $stmt=$conn->prepare("SELECT * FROM funcionarios WHERE usuario=? LIMIT 1");
    $stmt->execute([$u]);
    $user=$stmt->fetch(PDO::FETCH_ASSOC);
    if($user && password_verify($s,$user['senha'])){
        $_SESSION['id']=$user['id'];
        header("Location: index.php");
        exit;
    }
    $erro="Login inválido";
}
?>
<form method='post'>
<input name='usuario'>
<input name='senha' type='password'>
<button>Entrar</button>
<?= $erro ?? '' ?>
</form>
