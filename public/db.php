
<?php
$servidor = "localhost";
$usuario = "root";
$senha_db = "root";
$nome_banco = "ferrovia_db";

// Criar conexão
$conn = new mysqli($servidor, $usuario, $senha_db, $nome_banco);

// Verificar conexão
if ($conn->connect_error) {
  die("Conexão falhou: " . $conn->connect_error);
}

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

?>