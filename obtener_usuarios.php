<?php

header('Content-Type: application/json');

define('ACCESO_PERMITIDO', true);
require_once "C:/wamp64/config_privado/config.php";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset("utf8mb4");

$sql = "SELECT id, ficha, usuario, apellido, correo, telefono, curp, cargo FROM usuarios";

$result = $conn->query($sql);

$usuarios = [];

while($fila = $result->fetch_assoc()){
    $usuarios[] = $fila;
}

echo json_encode($usuarios);

$conn->close();

?>