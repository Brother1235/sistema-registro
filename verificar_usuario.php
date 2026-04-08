<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* 🔐 Permitir acceso al config */
define('ACCESO_PERMITIDO', true);

/* 🔐 Cargar configuración segura */
require_once $_SERVER['DOCUMENT_ROOT'] . "/../config_privado/config.php";

/* 🔌 Conectar a la base */
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset("utf8mb4");

if ($conn->connect_error) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Error de conexión a la base de datos"
    ]);
    exit();
}

/* 📥 Recibir datos */
$data = json_decode(file_get_contents("php://input"), true);

$usuario = trim($data['usuario'] ?? '');
$correo  = trim($data['correo'] ?? '');

if (!$usuario || !$correo) {
    echo json_encode([
        "success" => false,
        "mensaje" => "Todos los campos son obligatorios"
    ]);
    exit();
}

/* 🔎 Buscar usuario con prepared statement */
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? AND correo = ?");
$stmt->bind_param("ss", $usuario, $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {

    echo json_encode([
        "success" => true,
        "mensaje" => "Usuario encontrado"
    ]);

} else {

    echo json_encode([
        "success" => false,
        "mensaje" => "Usuario o correo no registrado"
    ]);
}

$stmt->close();
$conn->close();
?>