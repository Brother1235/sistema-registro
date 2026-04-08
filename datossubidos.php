<?php

header('Content-Type: application/json');
require_once "conexion.php";

$sql="SELECT * FROM beneficiarios";

$result=$conn->query($sql);

$datos=[];

while($fila=$result->fetch_assoc()){
$datos[]=$fila;
}

echo json_encode($datos);

$conn->close();

?>