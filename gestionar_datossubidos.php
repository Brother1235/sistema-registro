<?php

header('Content-Type: application/json');
require_once "conexion.php";

/* RECIBIR DATOS */
$data = json_decode(file_get_contents("php://input"), true);

if(!$data){
    echo json_encode(["success"=>false, "mensaje"=>"No se recibieron datos"]);
    exit();
}

$accion = $data["accion"] ?? "";


/* ================= EDITAR ================= */

if($accion === "editar"){

    $edad = intval($data["edad"]);

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
    destino=?,
    no_traslado=?,
    ficha_registro=?
    WHERE id=?";

    $stmt = $conn->prepare($sql);

    if(!$stmt){
        echo json_encode([
            "success"=>false,
            "error"=>$conn->error
        ]);
        exit();
    }

    $stmt->bind_param(
        "ssssssssssssssissssi",

        $data["apellido_paterno"],
        $data["apellido_materno"],
        $data["nombre"],
        $data["fecha_nacimiento"],
        $data["curp"],
        $data["telefono"],
        $data["domicilio"],
        $data["codigo_postal"],
        $data["localidad"],
        $data["municipio"],
        $data["nombre_responsable"],
        $data["telefono_responsable"],
        $data["sexo"],
        $edad,
        $data["diagnostico"],
        $data["origen"],
        $data["destino"],
        $data["no_traslado"],
        $data["ficha_registro"],
        $data["id"]
    );

    if($stmt->execute()){
        echo json_encode(["success"=>true]);
    }else{
        echo json_encode([
            "success"=>false,
            "error"=>$stmt->error
        ]);
    }

    $stmt->close();
}


/* ================= ELIMINAR ================= */

elseif($accion === "eliminar"){

    $stmt = $conn->prepare("DELETE FROM beneficiarios WHERE id=?");

    if(!$stmt){
        echo json_encode([
            "success"=>false,
            "error"=>$conn->error
        ]);
        exit();
    }

    $stmt->bind_param("i",$data["id"]);

    if($stmt->execute()){
        echo json_encode(["success"=>true]);
    }else{
        echo json_encode([
            "success"=>false,
            "error"=>$stmt->error
        ]);
    }

    $stmt->close();
}


/* ================= ACCIÓN NO VÁLIDA ================= */

else{
    echo json_encode([
        "success"=>false,
        "mensaje"=>"Acción no válida"
    ]);
}

$conn->close();

?>