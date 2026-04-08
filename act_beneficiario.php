<?php
session_start();
require_once "conexion.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/* Verificar sesión */
if(!isset($_SESSION['id_usuario'])){
    echo "No hay sesión iniciada";
    exit();
}

/* Recibir datos del formulario */
$id = intval($_POST['id'] ?? 0);
$apellido_paterno = $_POST['apellido_paterno'] ?? '';
$apellido_materno = $_POST['apellido_materno'] ?? '';
$nombre = $_POST['nombre'] ?? '';
$fecha_nacimiento = $_POST['fecha_nacimiento'] ?? '';
$curp = strtoupper($_POST['curp'] ?? '');
$telefono = $_POST['telefono'] ?? '';
$domicilio = $_POST['domicilio'] ?? '';
$codigo_postal = $_POST['codigo_postal'] ?? '';
$localidad = $_POST['localidad'] ?? '';
$municipio = $_POST['municipio'] ?? '';
$nombre_responsable = $_POST['nombre_responsable'] ?? '';
$telefono_responsable = $_POST['telefono_responsable'] ?? '';
$sexo = $_POST['sexo'] ?? '';
$edad = !empty($_POST['edad']) ? intval($_POST['edad']) : null;
$diagnostico = $_POST['diagnostico'] ?? '';
$origen = $_POST['origen'] ?? '';
$ficha_registro = $_POST['ficha_registro'] ?? '';

/* Preparar actualización */
$sql = "UPDATE beneficiarios SET 
    apellido_paterno=?, 
    apellido_materno=?, 
    nombre=?, 
    fecha_nacimiento=?, 
    curp=?, 
    telefono=?, 
    domicilio=?, 
    codigo_postal=?, 
    localidad=?, 
    municipio=?, 
    nombre_responsable=?, 
    telefono_responsable=?, 
    sexo=?, 
    edad=?, 
    diagnostico=?, 
    origen=?, 
    ficha_registro=? 
    WHERE id=?";

$stmt = $conn->prepare($sql);
if(!$stmt){
    die("Error en preparación: " . $conn->error);
}

$stmt->bind_param(
    "sssssssssssssssssi",
    $apellido_paterno,
    $apellido_materno,
    $nombre,
    $fecha_nacimiento,
    $curp,
    $telefono,
    $domicilio,
    $codigo_postal,
    $localidad,
    $municipio,
    $nombre_responsable,
    $telefono_responsable,
    $sexo,
    $edad,
    $diagnostico,
    $origen,
    $ficha_registro,
    $id
);

/* Ejecutar actualización */
if($stmt->execute()){
    header("Location: ver_datos.php?mensaje=Datos actualizados correctamente.");
    exit();
}else{
    echo "Error al actualizar: " . $stmt->error;
}

$stmt->close();
$conn->close();