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



// try {
//     $conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
//   } catch (\Throwable $th) {
//     throw $th;
//   }


?>
