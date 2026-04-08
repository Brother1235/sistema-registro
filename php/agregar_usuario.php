<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

/* 🔐 Permitir acceso al config */
define('ACCESO_PERMITIDO', true);

/* 🔐 Cargar archivo seguro */
require_once "C:/wamp64/config_privado/config.php";

/* 🔌 Conectar a la base de datos */
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    echo json_encode([
        "success" => false,
        "mensaje" => "❌ Error de conexión a la base de datos."
    ]);
    exit();
}

/* 📥 Recibir datos JSON */
$data = json_decode(file_get_contents('php://input'), true);

$usuario    = trim($data['usuario'] ?? '');
$apellido   = trim($data['apellido'] ?? '');
$correo     = trim($data['correo'] ?? '');
$telefono   = trim($data['telefono'] ?? '');
$curp       = trim($data['curp'] ?? ''); // 🔹 CAMBIO AQUI
$contrasena = trim($data['contrasena'] ?? '');

/* ✅ Validar campos obligatorios */
if (!$usuario || !$apellido || !$correo || !$telefono || !$curp || !$contrasena) {
    echo json_encode([
        "success" => false,
        "mensaje" => "⚠️ Todos los campos son obligatorios."
    ]);
    exit();
}

/* 🔎 Verificar si ya existe usuario o correo */
$stmt = $conn->prepare("SELECT id FROM usuarios WHERE usuario = ? OR correo = ?");
$stmt->bind_param("ss", $usuario, $correo);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "mensaje" => "⚠️ El usuario o correo ya existe."
    ]);
    $stmt->close();
    $conn->close();
    exit();
}
$stmt->close();

/* 🔢 Generar ficha automática */
$result = $conn->query("SELECT ficha FROM usuarios ORDER BY id DESC LIMIT 1");
$fila = $result ? $result->fetch_assoc() : null;

if ($fila && !empty($fila['ficha'])) {
    $num = intval(substr($fila['ficha'], 2)) + 1;
} else {
    $num = 1;
}

$ficha = 'PZ' . str_pad($num, 3, '0', STR_PAD_LEFT);

/* 🔐 Encriptar contraseña */
$hashContrasena = password_hash($contrasena, PASSWORD_DEFAULT);

/* 📝 Insertar usuario */
$stmt = $conn->prepare("
    INSERT INTO usuarios 
    (ficha, cargo, usuario, apellido, correo, telefono, curp, contrasena) 
    VALUES (?, 'cliente', ?, ?, ?, ?, ?, ?)
");

$stmt->bind_param(
    "sssssss",
    $ficha,
    $usuario,
    $apellido,
    $correo,
    $telefono,
    $curp,
    $hashContrasena
);

if ($stmt->execute()) {
    echo json_encode([
        "success" => true,
        "mensaje" => "✅ Usuario registrado correctamente.",
        "ficha" => $ficha
    ]);
} else {
    echo json_encode([
        "success" => false,
        "mensaje" => "❌ Error al registrar el usuario."
    ]);
}

$stmt->close();
$conn->close();
?>