<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* 🔐 Permitir acceso al config */
define('ACCESO_PERMITIDO', true);

/* 🔐 Cargar archivo seguro con datos de conexión */
require_once "C:/wamp64/config_privado/config.php";

/* 🔌 Conexión a la base de datos */
$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset("utf8mb4");

if($conn->connect_error){
    echo json_encode([
        "success" => false,
        "mensaje" => "❌ Error de conexión a la base de datos: " . $conn->connect_error
    ]);
    exit();
}

/* 📥 Recibir datos desde JSON */
$data = json_decode(file_get_contents('php://input'), true);
$usuario = isset($data['usuario']) ? $conn->real_escape_string(trim($data['usuario'])) : '';
$contrasena = isset($data['contrasena']) ? $conn->real_escape_string(trim($data['contrasena'])) : '';

if(!$usuario || !$contrasena){
    echo json_encode([
        "success" => false,
        "mensaje" => "⚠️ Usuario y contraseña son obligatorios"
    ]);
    exit();
}

/* 🔐 Encriptar la nueva contraseña */
$hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

/* 📝 Actualizar la contraseña en la tabla usuarios */
$stmt = $conn->prepare("UPDATE usuarios SET contrasena=? WHERE usuario=?");
$stmt->bind_param("ss", $hashContrasena, $usuario);

if($stmt->execute()){
    echo json_encode([
        "success" => true,
        "mensaje" => "✅ Contraseña modificada correctamente"
    ]);
}else{
    echo json_encode([
        "success" => false,
        "mensaje" => "❌ Error al modificar la contraseña: " . $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>