<?php
header("Access-Control-Allow-Origin: *");  // Permite todas as origens
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$host = 'postgres-container';
$db = 'mydatabase';
$user = 'myuser';
$pass = 'mypassword';
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$user;password=$pass";

$response = ['message' => 'Hello from the backend'];  // Resposta padrão

try {
    $pdo = new PDO($dsn);
    if ($pdo) {
        $response['db_connection'] = 'Conexão com o PostgreSQL realizada com sucesso!';
    }
} catch (PDOException $e) {
    $response['db_connection_error'] = $e->getMessage();
}
echo json_encode($response);
?>
