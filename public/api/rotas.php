<?php
require_once 'common.php';
$method = $_SERVER['REQUEST_METHOD'];
if ($method==='GET') { $res=mysqli_query($conn,"SELECT * FROM rotas ORDER BY id DESC"); send(['success'=>true,'data'=>mysqli_fetch_all($res,MYSQLI_ASSOC)]); }
if ($method==='POST') { $d=input_json(); $st=mysqli_prepare($conn,"INSERT INTO rotas (nome,origem,destino,duracao_min,ativo) VALUES (?,?,?,?,?)"); mysqli_stmt_bind_param($st,"sssii",$d['nome'],$d['origem'],$d['destino'],$d['duracao_min'],$d['ativo']); mysqli_stmt_execute($st); send(['success'=>true,'id'=>mysqli_insert_id($conn)],201); }
if ($method==='PUT') { $d=input_json(); if(empty($d['id'])) send(['success'=>false,'error'=>'missing id'],400); $st=mysqli_prepare($conn,"UPDATE rotas SET nome=?,origem=?,destino=?,duracao_min=?,ativo=? WHERE id=?"); mysqli_stmt_bind_param($st,"sssiii",$d['nome'],$d['origem'],$d['destino'],$d['duracao_min'],$d['ativo'],$d['id']); mysqli_stmt_execute($st); send(['success'=>true]); }
if ($method==='DELETE') { $id=intval($_GET['id']??0); if(!$id) send(['success'=>false,'error'=>'missing id'],400); $st=mysqli_prepare($conn,"DELETE FROM rotas WHERE id=?"); mysqli_stmt_bind_param($st,"i",$id); mysqli_stmt_execute($st); send(['success'=>true]); }
send(['success'=>false,'error'=>'method not allowed'],405);
