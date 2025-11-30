<?php
require_once 'common.php';

$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'GET') {
    $res = mysqli_query($conn, "SELECT * FROM trens ORDER BY id DESC");
    $rows = mysqli_fetch_all($res, MYSQLI_ASSOC);
    send(['success'=>true,'data'=>$rows]);
}

if ($method === 'POST') {
    $d = input_json();
    $sql = "INSERT INTO trens (codigo, descricao, capacidade, status) VALUES (?,?,?,?)";
    $st = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($st,"ssis",$d['codigo'],$d['descricao'],$d['capacidade'],$d['status']);
    mysqli_stmt_execute($st);
    send(['success'=>true,'id'=>mysqli_insert_id($conn)],201);
}

if ($method === 'PUT') {
    $d = input_json();
    if (empty($d['id'])) send(['success'=>false,'error'=>'missing id'],400);
    $sql = "UPDATE trens SET codigo=?, descricao=?, capacidade=?, status=? WHERE id=?";
    $st = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($st,"ssisi",$d['codigo'],$d['descricao'],$d['capacidade'],$d['status'],$d['id']);
    mysqli_stmt_execute($st);
    send(['success'=>true]);
}

if ($method === 'DELETE') {
    $id = intval($_GET['id'] ?? 0);
    if (!$id) send(['success'=>false,'error'=>'missing id'],400);
    $st = mysqli_prepare($conn,"DELETE FROM trens WHERE id=?");
    mysqli_stmt_bind_param($st,"i",$id);
    mysqli_stmt_execute($st);
    send(['success'=>true]);
}
send(['success'=>false,'error'=>'method not allowed'],405);
