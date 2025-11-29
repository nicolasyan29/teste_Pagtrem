<?php
// config/db.php - ajuste as credenciais conforme seu ambiente
$DB_HOST = '127.0.0.1';
$DB_NAME = 'ferrovia_db';
$DB_USER = 'root';
$DB_PASS = '';
$DB_PORT = '3306';

try {
    $dsn = "mysql:host={$DB_HOST};port={$DB_PORT};dbname={$DB_NAME};charset=utf8mb4";
    $pdo = new PDO($dsn, $DB_USER, $DB_PASS, [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
} catch (PDOException $e) {
    // Em produção, logue o erro em vez de exibir
    die("Erro na conexão com o banco: " . $e->getMessage());
}

if (session_status() === PHP_SESSION_NONE) session_start();
