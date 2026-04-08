<?php
header('Content-Type: application/json');
require_once "conexion.php";

// CONSULTA
$query = "SELECT sexo FROM beneficiarios";
$result = $conn->query($query);

// VARIABLES
$hombres = 0;
$mujeres = 0;

// RECORRER RESULTADOS
while($row = $result->fetch_assoc()){
    $sexo = strtoupper(trim($row['sexo']));

    if($sexo == "MASCULINO"){
        $hombres++;
    } elseif($sexo == "FEMENINO"){
        $mujeres++;
    }
}

// RESPUESTA JSON
echo json_encode([
    "success" => true,
    "hombres" => $hombres,
    "mujeres" => $mujeres
]);
?>