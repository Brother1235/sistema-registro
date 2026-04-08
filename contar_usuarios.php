<?php

header('Content-Type: application/json');

define('ACCESO_PERMITIDO', true);
require_once "C:/wamp64/config_privado/config.php";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset("utf8mb4");

// CONTAR USUARIOS
$sql = "SELECT COUNT(*) as total FROM usuarios";
$result = $conn->query($sql);

if($result){
    $row = $result->fetch_assoc();

    echo json_encode([
        "success" => true,
        "total" => $row["total"]
    ]);
}else{
    echo json_encode([
        "success" => false,
        "error" => $conn->error
    ]);
}

$conn->close();

?>