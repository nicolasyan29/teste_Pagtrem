<?php
// Ativar exibição de erros
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

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

// Garantir charset correto
$conn->set_charset('utf8mb4');

if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

?>