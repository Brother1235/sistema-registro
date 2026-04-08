<?php
require_once "conexion.php";

/* RECIBIR DATOS JSON */
$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
echo json_encode(["success"=>false,"error"=>"No se recibieron datos"]);
exit();
}

/* ---------- EDITAR USUARIO ---------- */
if($data["accion"] === "editar"){

$id = $data["id"];
$usuario = $data["usuario"];
$apellido = $data["apellido"];
$correo = $data["correo"];
$telefono = $data["telefono"];
$curp = $data["curp"];
$cargo = $data["cargo"];
$contrasena = $data["contrasena"];

/* 🔥 SI HAY CONTRASEÑA NUEVA */
if(!empty($contrasena)){

/* ENCRIPTAR */
$hash = password_hash($contrasena, PASSWORD_DEFAULT);

$sql = "UPDATE usuarios SET 
usuario=?, 
apellido=?, 
correo=?, 
telefono=?, 
curp=?, 
cargo=?,
contrasena=?
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssssi",
$usuario,
$apellido,
$correo,
$telefono,
$curp,
$cargo,
$hash,
$id
);

}else{

/* 🔥 SIN CAMBIAR CONTRASEÑA */
$sql = "UPDATE usuarios SET 
usuario=?, 
apellido=?, 
correo=?, 
telefono=?, 
curp=?, 
cargo=?
WHERE id=?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ssssssi",
$usuario,
$apellido,
$correo,
$telefono,
$curp,
$cargo,
$id
);

}

if($stmt->execute()){
echo json_encode(["success"=>true]);
}else{
echo json_encode([
"success"=>false,
"error"=>$stmt->error
]);
}

$stmt->close();
$conn->close();
exit();

}


/* ---------- ELIMINAR USUARIO ---------- */
if($data["accion"] === "eliminar"){

$id = $data["id"];

$sql = "DELETE FROM usuarios WHERE id=?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i",$id);

if($stmt->execute()){
echo json_encode(["success"=>true]);
}else{
echo json_encode([
"success"=>false,
"error"=>$stmt->error
]);
}

$stmt->close();
$conn->close();
exit();

}


/* ---------- ACCIÓN NO VÁLIDA ---------- */
echo json_encode([
"success"=>false,
"error"=>"Acción no válida"
]);

?>