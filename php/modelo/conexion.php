<?php
/* Railway exposes these variables from its MySQL service. Local values remain as fallbacks for XAMPP. */
$host = getenv('MYSQLHOST') ?: getenv('DB_HOST') ?: 'localhost';
$usuario = getenv('MYSQLUSER') ?: getenv('DB_USER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: getenv('DB_PASSWORD') ?: '';
$bd = getenv('MYSQLDATABASE') ?: getenv('DB_NAME') ?: 'la_pesquera';
$puerto = (int)(getenv('MYSQLPORT') ?: getenv('DB_PORT') ?: 3307);

$conexion = @new mysqli($host, $usuario, $password, $bd, $puerto);
if ($conexion->connect_error) {
    http_response_code(500);
    exit('No fue posible conectar con la base de datos.');
}
$conexion->set_charset('utf8mb4');
?>
