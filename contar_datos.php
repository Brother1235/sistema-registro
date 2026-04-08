<?php

header('Content-Type: application/json');
require_once "conexion.php";

// CONTAR REGISTROS DE BENEFICIARIOS
$sql = "SELECT COUNT(*) as total FROM beneficiarios";
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