<?php
session_start();
require_once "conexion.php";

$data = json_decode(file_get_contents("php://input"), true);

if(!$data || !isset($data['id'])){
    echo json_encode(["success"=>false,"mensaje"=>"Datos inválidos"]);
    exit();
}

$id = $data['id'];
$campos = [
    'apellido_paterno',
    'apellido_materno',
    'nombre',
    'fecha_nacimiento',
    'curp',
    'telefono',
    'domicilio',
    'localidad',
    'municipio',
    'nombre_responsable',
    'telefono_responsable',
    'sexo',
    'edad',
    'diagnostico',
    'origen'
];

// Preparar SQL dinámico
$sql = "UPDATE beneficiarios SET ";
$sql .= implode(" = ?, ", $campos) . " = ? WHERE id = ?";
$stmt = $conn->prepare($sql);

// Bind parámetros dinámico
$tipos = str_repeat("s", count($campos)) . "i"; // todos string + id int
$valores = [];
foreach($campos as $c) $valores[] = $data[$c] ?? '';
$valores[] = $id;

$stmt->bind_param($tipos, ...$valores);

if($stmt->execute()){
    echo json_encode(["success"=>true]);
}else{
    echo json_encode(["success"=>false]);
}

$stmt->close();
$conn->close();
?>