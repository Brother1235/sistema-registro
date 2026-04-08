<?php
header('Content-Type: application/json');
session_start();
require_once "conexion.php";

/* 📥 Recibir datos del formulario */
$apellidoPaterno     = $_POST['apellido_paterno'] ?? '';
$apellidoMaterno     = $_POST['apellido_materno'] ?? '';
$nombre              = $_POST['nombres'] ?? '';
$fechaNacimiento     = $_POST['fecha_nacimiento'] ?? '';
$curp                = $_POST['curp'] ?? '';
$telefono            = $_POST['telefono_beneficiario'] ?? '';
$domicilio           = $_POST['domicilio'] ?? '';
$codigoPostal        = $_POST['codigo_postal'] ?? '';
$localidad           = $_POST['localidad'] ?? '';
$municipio           = $_POST['municipio'] ?? '';
$nombreResponsable   = $_POST['nombre_responsable'] ?? '';
$telefonoResponsable = $_POST['telefono_responsable'] ?? '';
$sexo                = $_POST['sexo'] ?? '';
$edad                = $_POST['edad'] ?? '';
$diagnostico         = $_POST['diagnostico'] ?? '';
$origen              = $_POST['origen'] ?? '';

/* 🔥 NUEVOS CAMPOS VACÍOS */
$destino      = "";
$no_traslado  = "";

/* 🔠 MAYÚSCULAS */
function mayus($texto){
    return mb_strtoupper($texto, 'UTF-8');
}

$apellidoPaterno   = mayus($apellidoPaterno);
$apellidoMaterno   = mayus($apellidoMaterno);
$nombre            = mayus($nombre);
$curp              = mayus($curp);
$domicilio         = mayus($domicilio);
$localidad         = mayus($localidad);
$municipio         = mayus($municipio);
$nombreResponsable = mayus($nombreResponsable);
$diagnostico       = mayus($diagnostico);
$origen            = mayus($origen);
$sexo              = mayus($sexo);

/* 🔹 SESIÓN */
$usuarioRegistro = $_SESSION['usuario'] ?? 'Desconocido';
$fichaRegistro   = $_SESSION['ficha'] ?? 'Desconocida';

/* 🔹 FECHA */
$fechaRegistro = date("Y-m-d H:i:s");

/* 🔌 INSERT */
$stmt = $conn->prepare("
INSERT INTO beneficiarios
(
apellido_paterno,
apellido_materno,
nombre,
fecha_nacimiento,
curp,
telefono,
domicilio,
codigo_postal,
localidad,
municipio,
nombre_responsable,
telefono_responsable,
sexo,
edad,
diagnostico,
origen,
destino,
no_traslado,
usuario_registro,
ficha_registro,
fecha_registro
)
VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)
");

$stmt->bind_param(
"sssssssssssssisssssss",
$apellidoPaterno,
$apellidoMaterno,
$nombre,
$fechaNacimiento,
$curp,
$telefono,
$domicilio,
$codigoPostal,
$localidad,
$municipio,
$nombreResponsable,
$telefonoResponsable,
$sexo,
$edad,
$diagnostico,
$origen,
$destino,
$no_traslado,
$usuarioRegistro,
$fichaRegistro,
$fechaRegistro
);

/* RESPUESTA */
if($stmt->execute()){
    echo json_encode([
        "success" => true,
        "mensaje" => "Beneficiario registrado correctamente ✅",
        "usuario" => $usuarioRegistro,
        "ficha"   => $fichaRegistro,
        "fecha"   => $fechaRegistro
    ]);
}else{
    echo json_encode([
        "success" => false,
        "mensaje" => "Error al guardar ❌",
        "error" => $stmt->error
    ]);
}

$stmt->close();
$conn->close();
?>