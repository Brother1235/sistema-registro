<?php
session_start();
require_once "conexion.php";

/* verificar sesión */
if(!isset($_SESSION['usuario'])){
    header("Location: login.php");
    exit();
}

/* verificar que venga del formulario */
if($_SERVER["REQUEST_METHOD"] == "POST"){

$id = $_POST['id'];
$usuario = $_POST['usuario'];
$apellido = $_POST['apellido'];
$correo = $_POST['correo'];
$telefono = $_POST['telefono'];
$curp = $_POST['curp'];
$contrasena = $_POST['contrasena'];

/* actualizar SIN cambiar contraseña */
if(empty($contrasena)){

$sql = "UPDATE usuarios SET 
usuario=?,
apellido=?,
correo=?,
telefono=?,
curp=?
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssi",$usuario,$apellido,$correo,$telefono,$curp,$id);

}else{

/* actualizar CON contraseña */

$sql = "UPDATE usuarios SET 
usuario=?,
apellido=?,
correo=?,
telefono=?,
curp=?,
contrasena=?
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi",$usuario,$apellido,$correo,$telefono,$curp,$contrasena,$id);

}

$stmt->execute();

/* si el usuario cambió se cierra sesión */

if($usuario != $_SESSION['usuario']){
session_destroy();
header("Location: index.html");
exit();
}

/* regresar al index */

header("Location: index.php?mensaje=1");
exit();

}
?>