<?php
header("Access-Control-Allow-Origin: *");  // Permite todas as origens
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

$host = 'postgres-container';
$db = 'mydatabase';
$user = 'myuser';
$pass = 'mypassword';
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$user;password=$pass";

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
  http_response_code(200);
  exit; // Finaliza a execução para não processar mais nada
}

try {
    $pdo = new PDO($dsn);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Para exibir erros de SQL

} catch (PDOException $e) {
    echo json_encode(['db_connection_error' => $e->getMessage()]);
    exit;
}
