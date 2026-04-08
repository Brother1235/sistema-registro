<?php
header('Content-Type: application/json');
session_start();
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
$contrasena = trim($data['contrasena'] ?? '');

/* ✅ Validar campos obligatorios */
if (!$usuario || !$contrasena) {
    echo json_encode([
        "success" => false,
        "mensaje" => "⚠️ Todos los campos son obligatorios."
    ]);
    exit();
}

/* 🔹 Buscar usuario en la base de datos */
$stmt = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ?");
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $fila = $result->fetch_assoc();

    // 🔹 Verificar la contraseña usando password_verify
    if (password_verify($contrasena, $fila['contrasena'])) {
        // 🔹 Guardamos los datos en sesión
        $_SESSION['usuario'] = $fila['usuario'];
        $_SESSION['cargo'] = $fila['cargo'];
        $_SESSION['ficha'] = $fila['ficha'];

        // 🔹 Determinar el tipo de usuario según el campo 'cargo'
        $tipo = strtolower($fila['cargo']) === 'administrador' ? 'admin' : 'cliente';
        $mensaje = $tipo === 'admin' ? "Bienvenido Administrador " . ucfirst($fila['usuario']) : "Bienvenido " . ucfirst($fila['usuario']);

        // 🔹 Devolvemos la respuesta al JavaScript
        echo json_encode([
            "success" => true,
            "mensaje" => $mensaje,
            "usuario" => $fila['usuario'],
            "tipo" => $tipo,
            "ficha" => $fila['ficha']
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "mensaje" => "Usuario o contraseña incorrectos."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "mensaje" => "Usuario o contraseña incorrectos."
    ]);
}

$stmt->close();
$conn->close();
?>