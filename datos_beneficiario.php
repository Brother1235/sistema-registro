<?php
header('Content-Type: application/json');
require_once "conexion.php"; // Conexión a la DB

// Obtener el id del beneficiario por GET
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0){
    echo json_encode([
        "success" => false,
        "error" => "ID inválido"
    ]);
    exit();
}

// Consulta para obtener datos
$sql = "SELECT * FROM beneficiarios WHERE id = ?";
$stmt = $conn->prepare($sql);

if(!$stmt){
    echo json_encode([
        "success" => false,
        "error" => $conn->error
    ]);
    exit();
}

$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){
    $beneficiario = $result->fetch_assoc();
    echo json_encode([
        "success" => true,
        "beneficiario" => $beneficiario
    ]);
}else{
    echo json_encode([
        "success" => false,
        "error" => "Beneficiario no encontrado"
    ]);
}

$stmt->close();
$conn->close();
?>