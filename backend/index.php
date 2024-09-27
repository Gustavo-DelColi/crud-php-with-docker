<?php
require_once('./config.php');

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);
    exit; // Finaliza a execução para não processar mais nada
}

$response = ['message' => 'Hello from the backend'];
if ($pdo) {
    $response['db_connection'] = 'Conexão com o PostgreSQL realizada com sucesso!';
}


echo json_encode($response);
?>
