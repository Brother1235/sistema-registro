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
        "mensaje" => "❌ Error de conexión: " . $conn->connect_error
    ]);
    exit();
}

/* 📥 Recibir datos desde JSON */
$data = json_decode(file_get_contents('php://input'), true);

$usuario    = isset($data['usuario']) ? trim($data['usuario']) : '';
$ficha      = isset($data['ficha']) ? trim($data['ficha']) : '';
$curp       = isset($data['curp']) ? trim($data['curp']) : '';
$contrasena = isset($data['contrasena']) ? trim($data['contrasena']) : '';

/* ⚠️ Validar campos */
if(!$usuario || !$ficha || !$curp || !$contrasena){
    echo json_encode([
        "success" => false,
        "mensaje" => "⚠️ Todos los campos son obligatorios"
    ]);
    exit();
}

/* 🔍 Verificar que exista el usuario con ficha y curp */
$verificar = $conn->prepare("SELECT id FROM usuarios WHERE usuario=? AND ficha=? AND curp=?");
$verificar->bind_param("sss", $usuario, $ficha, $curp);
$verificar->execute();
$resultado = $verificar->get_result();

if($resultado->num_rows === 0){
    echo json_encode([
        "success" => false,
        "mensaje" => "❌ Los datos no coinciden con ningún usuario"
    ]);
    $verificar->close();
    $conn->close();
    exit();
}

/* 🔐 Encriptar nueva contraseña */
$hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

/* 📝 Actualizar contraseña */
$actualizar = $conn->prepare("UPDATE usuarios SET contrasena=? WHERE usuario=? AND ficha=? AND curp=?");
$actualizar->bind_param("ssss", $hashContrasena, $usuario, $ficha, $curp);

if($actualizar->execute()){
    echo json_encode([
        "success" => true,
        "mensaje" => "✅ Contraseña modificada correctamente"
    ]);
}else{
    echo json_encode([
        "success" => false,
        "mensaje" => "❌ Error al actualizar: " . $actualizar->error
    ]);
}

$verificar->close();
$actualizar->close();
$conn->close();
?>