<?php
// Establecer la conexión con la base de datos
$host = 'localhost'; // o tu servidor de base de datos
$user = 'tu_usuario'; // tu nombre de usuario de MySQL
$pass = 'tu_contraseña'; // tu contraseña de MySQL
$dbname = 'chat'; // nombre de la base de datos

// Crear la conexión
$conn = new mysqli($host, $user, $pass, $dbname);

// Verificar la conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}
?>
