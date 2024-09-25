<?php
header("Access-Control-Allow-Origin: *");  // Permite todas as origens
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

$host = 'postgres-container';
$db = 'mydatabase';
$user = 'myuser';
$pass = 'mypassword';
$dsn = "pgsql:host=$host;port=5432;dbname=$db;user=$user;password=$pass";

try {
    $pdo = new PDO($dsn);
    if ($pdo) {
        echo "Conexão com o PostgreSQL realizada com sucesso!";
    }
} catch (PDOException $e) {
    echo $e->getMessage();
}
?>
