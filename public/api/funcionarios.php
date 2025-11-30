<?php
require_once 'common.php';
$method = $_SERVER['REQUEST_METHOD'];
if ($method==='GET') {
    $res=mysqli_query($conn,"SELECT * FROM funcionarios ORDER BY id DESC");
    send(['success'=>true,'data'=>mysqli_fetch_all($res,MYSQLI_ASSOC)]);
}
if ($method==='POST') {
    $d = input_json();
    $sql = "INSERT INTO funcionarios (nome,cpf,cargo,email,telefone,cep,rua,bairro,cidade,estado,localizacao) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
    $st = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($st,"sssssssssss",$d['nome'],$d['cpf'],$d['cargo'],$d['email'],$d['telefone'],$d['cep'],$d['rua'],$d['bairro'],$d['cidade'],$d['estado'],$d['localizacao']);
    mysqli_stmt_execute($st);
    send(['success'=>true,'id'=>mysqli_insert_id($conn)],201);
}
if ($method==='PUT') {
    $d = input_json();
    if (empty($d['id'])) send(['success'=>false,'error'=>'missing id'],400);
    $sql = "UPDATE funcionarios SET nome=?,cpf=?,cargo=?,email=?,telefone=?,cep=?,rua=?,bairro=?,cidade=?,estado=?,localizacao=? WHERE id=?";
    $st = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($st,"sssssssssssi",$d['nome'],$d['cpf'],$d['cargo'],$d['email'],$d['telefone'],$d['cep'],$d['rua'],$d['bairro'],$d['cidade'],$d['estado'],$d['localizacao'],$d['id']);
    mysqli_stmt_execute($st);
    send(['success'=>true]);
}
if ($method==='DELETE') {
    $id = intval($_GET['id'] ?? 0);
    if (!$id) send(['success'=>false,'error'=>'missing id'],400);
    $st = mysqli_prepare($conn,"DELETE FROM funcionarios WHERE id=?");
    mysqli_stmt_bind_param($st,"i",$id);
    mysqli_stmt_execute($st);
    send(['success'=>true]);
}
send(['success'=>false,'error'=>'method not allowed'],405);
