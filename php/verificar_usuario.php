<?php
header('Content-Type: application/json');

define('ACCESO_PERMITIDO', true);
require_once "C:/wamp64/config_privado/config.php";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset("utf8mb4");

$data = json_decode(file_get_contents("php://input"), true);

$usuario = trim($data['usuario'] ?? '');
$curp    = trim($data['curp'] ?? '');

if (!$usuario || !$curp) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Todos los campos son obligatorios."
    ]);
    exit();
}

/* 🔎 Verificar si existe el usuario */
$stmt = $conn->prepare("SELECT curp FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "El usuario no existe."
    ]);
    exit();
}

$fila = $result->fetch_assoc();

/* 🔐 Verificar CURP */
if ($fila['curp'] !== $curp) {
    echo json_encode([
        "success" => false,
        "mensaje" => "La CURP no coincide con el usuario."
    ]);
    exit();
}

echo json_encode([
    "success" => true,
    "mensaje" => "Datos correctos."
]);

$stmt->close();
$conn->close();
?>