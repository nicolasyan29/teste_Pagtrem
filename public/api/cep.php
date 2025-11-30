<?php
// public/api/cep.php
header('Content-Type: application/json; charset=utf-8');
$cep = preg_replace('/\D/','', $_GET['cep'] ?? '');
if (!$cep || strlen($cep) !== 8) { http_response_code(400); echo json_encode(['error'=>'CEP inválido']); exit; }
$u = "https://viacep.com.br/ws/{$cep}/json/";
$opts = ['http'=>['timeout'=>5]];
$context = stream_context_create($opts);
$resp = @file_get_contents($u,false,$context);
if ($resp === false) { http_response_code(502); echo json_encode(['error'=>'erro viacep']); exit; }
$data = json_decode($resp, true);
if (!$data || isset($data['erro'])) { http_response_code(404); echo json_encode(['error'=>'não encontrado']); exit; }
echo json_encode($data, JSON_UNESCAPED_UNICODE);
