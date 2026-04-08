<?php
header('Content-Type: application/json');
require_once "conexion.php";

$sql = "SELECT comentario FROM comentarios ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "comentario" => $row['comentario']
    ]);
} else {
    echo json_encode([
        "success" => false,
        "comentario" => "No hay consejos disponibles"
    ]);
}

$conn->close();
?>