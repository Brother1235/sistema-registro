<?php
// DATOS DE CONEXIÓN
$host = "localhost";
$user = "root";
$pass = "";
$db   = "dif_proyecto";

// CREAR CONEXIÓN
$conn = new mysqli($host, $user, $pass, $db);

// VERIFICAR CONEXIÓN
if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// CONFIGURAR UTF-8
$conn->set_charset("utf8");
?>