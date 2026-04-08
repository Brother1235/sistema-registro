<?php
header('Content-Type: application/json');

require_once "conexion.php";

// leer JSON
$data = json_decode(file_get_contents("php://input"), true);

// validar datos
if(!$data || !isset($data['comentario']) || !isset($data['id'])){
    echo json_encode([
        "success" => false,
        "mensaje" => "Datos incompletos"
    ]);
    exit();
}

$id = $data['id'];
$comentario = $data['comentario'];

// validar comentario vacío
if(trim($comentario) == ""){
    echo json_encode([
        "success" => false,
        "mensaje" => "Comentario vacío"
    ]);
    exit();
}

/* 🔥 VERIFICAR SI YA EXISTE */
$sql = "SELECT id FROM comentarios WHERE id_beneficiario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result->num_rows > 0){

    /* 🔁 ACTUALIZAR */
    $sql = "UPDATE comentarios SET comentario = ? WHERE id_beneficiario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $comentario, $id);

    if($stmt->execute()){
        echo json_encode([
            "success" => true,
            "mensaje" => "Comentario actualizado correctamente"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "Error al actualizar"
        ]);
    }

}else{

    /* ➕ INSERTAR */
    $sql = "INSERT INTO comentarios (id_beneficiario, comentario) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id, $comentario);

    if($stmt->execute()){
        echo json_encode([
            "success" => true,
            "mensaje" => "Comentario guardado"
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "Error al guardar"
        ]);
    }

}

$stmt->close();
$conn->close();
?>