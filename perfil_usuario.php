<?php
session_start();
require_once "conexion.php";

header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$usuarioNuevo = $data['usuario'];
$apellido = $data['apellido'];
$correo = $data['correo'];
$telefono = $data['telefono'];
$curp = $data['curp'];
$contrasena = $data['contrasena'];

$usuarioActual = $_SESSION['usuario'];

/* contraseña */
if(!empty($contrasena)){
$contrasenaHash = password_hash($contrasena, PASSWORD_DEFAULT);

$sql = "UPDATE usuarios 
SET usuario=?, apellido=?, correo=?, telefono=?, curp=?, contrasena=? 
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi",
$usuarioNuevo,$apellido,$correo,$telefono,$curp,$contrasenaHash,$id);

}else{

$sql = "UPDATE usuarios 
SET usuario=?, apellido=?, correo=?, telefono=?, curp=? 
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi",
$usuarioNuevo,$apellido,$correo,$telefono,$curp,$id);
}

if($stmt->execute()){

if($usuarioNuevo !== $usuarioActual){

session_destroy();

echo json_encode([
"success"=>true,
"logout"=>true
]);

}else{

$_SESSION['usuario']=$usuarioNuevo;

echo json_encode([
"success"=>true,
"logout"=>false
]);
}

}else{
echo json_encode([
"success"=>false,
"error"=>$stmt->error
]);
}

$stmt->close();
$conn->close();
?>