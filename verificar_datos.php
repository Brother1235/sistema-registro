<?php
session_start();
require_once "conexion.php";

header('Content-Type: application/json');

$usuario = $_SESSION['usuario'] ?? '';

if($usuario == ""){
    echo json_encode(["existe"=>false]);
    exit;
}

/* verificar si ya tiene registro */
$stmt = $conn->prepare("SELECT id FROM beneficiarios WHERE usuario_registro = ? LIMIT 1");
$stmt->bind_param("s",$usuario);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    echo json_encode(["existe"=>true]);
}else{
    echo json_encode(["existe"=>false]);
}

$stmt->close();
$conn->close();
?>