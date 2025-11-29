<?php
// lib/cep_lookup.php
// Função para consultar ViaCEP no servidor (cURL preferencial)
function buscar_cep_servidor(string $cep) {
    $cep = preg_replace('/\D/', '', $cep);
    if (strlen($cep) !== 8) return false;

    $url = "https://viacep.com.br/ws/{$cep}/json/";

    if (function_exists('curl_version')) {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 5);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        $resp = curl_exec($ch);
        curl_close($ch);
        if ($resp === false) return false;
    } else {
        $resp = @file_get_contents($url);
        if ($resp === false) return false;
    }

    $data = json_decode($resp, true);
    if (!is_array($data) || isset($data['erro'])) return false;

    return [
        'cep' => $data['cep'] ?? null,
        'rua' => $data['logradouro'] ?? '',
        'bairro' => $data['bairro'] ?? '',
        'cidade' => $data['localidade'] ?? '',
        'estado' => $data['uf'] ?? ''
    ];
}
