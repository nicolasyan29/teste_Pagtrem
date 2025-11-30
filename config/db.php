<?php
$DB_HOST = '127.0.0.1';
$DB_NAME = 'ferrovia_db';
$DB_USER = 'root';
$DB_PASS = '';
$DB_PORT = '3306';

$conn = mysqli_connect($DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $DB_PORT);

if (!$conn) {
    die("Erro ao conectar ao banco: " . mysqli_connect_error());
}

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
