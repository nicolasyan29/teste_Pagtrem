<?php
// api/common.php
require_once __DIR__.'/../..//config/db.php';
header('Content-Type: application/json; charset=utf-8');

function input_json(){
    $data = file_get_contents('php://input');
    return json_decode($data, true);
}

function send($data, $code=200){
    http_response_code($code);
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}
