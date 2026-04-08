<?php 
session_start();
require_once "conexion.php";

/* Verificar sesión */
if(!isset($_SESSION['usuario'])){
    echo "No hay sesión iniciada";
    exit();
}

$usuario = $_SESSION['usuario'];

/* Buscar datos */
$sql = "SELECT id, usuario, apellido, correo, telefono, curp 
        FROM usuarios WHERE usuario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s",$usuario);
$stmt->execute();
$resultado = $stmt->get_result();
$datos = $resultado->fetch_assoc();

if(!$datos){
    echo "Error al obtener datos";
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Editar Perfil</title>

<style>
/* RESET */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: Arial, Helvetica, sans-serif;
}

/* FONDO */
body {
    background: #4a148c; /* fondo morado uniforme */
    min-height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
}

/* HEADER */
header {
    background: #9c27b0; /* morado intenso igual que Beneficiarios */
    color: white;
    width: 100%;
    padding: 15px 25px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    box-shadow: 0 2px 6px rgba(0,0,0,0.2);
}

.titulo-header {
    font-size: 22px;
    font-weight: bold;
    text-align: center;
    flex: 1;
}

/* USUARIO HEADER */
.user-box {
    display: flex;
    align-items: center;
    gap: 10px;
}

.user-box img {
    width: 40px;
    height: 40px;
    border-radius: 50%;
    border: 2px solid white;
}

#nombreUsuario {
    font-weight: bold;
    background: white;  /* cuadro blanco como Beneficiarios */
    color: #4a148c;     /* texto morado */
    padding: 6px 12px;
    border-radius: 8px;
    font-size: 14px;
}

/* CONTENEDOR */
.container {
    width: 90%;
    max-width: 600px;
    margin: 30px auto;
}

/* TARJETA */
.card {
    background: white; /* tarjeta blanca como Beneficiarios */
    color: #4a148c;    /* texto morado */
    padding: 30px;
    border-radius: 12px;
    box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    transition: all 0.3s ease;
}

.card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.3);
}

/* FILAS DE DATOS */
.dato {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 15px;
    align-items: center;
}

/* ETIQUETAS */
.etiqueta {
    min-width: 130px;
    font-weight: bold;
    color: #4a148c; /* morado igual que Beneficiarios */
}

/* INPUTS */
input {
    flex: 1;
    padding: 10px;
    border-radius: 8px;
    border: 1px solid #ccc;
    background: #f3e5f5; /* lilac suave igual que Beneficiarios */
    color: #333;
    transition: all 0.2s ease;
}

input:focus {
    border-color: #9c27b0;
    outline: none;
    box-shadow: 0 0 8px rgba(156,39,176,0.5);
    background: white;
}

/* BOTONES */
.botones {
    text-align: right;
    margin-top: 20px;
}

.guardar {
    background: #9c27b0; /* morado intenso */
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    transition: all 0.3s ease;
}

.guardar:hover {
    background: #7b1fa2; /* morado más oscuro */
}

.regresar {
    background: #e91e63; /* rosa intenso para resaltar */
    color: white;
    border: none;
    padding: 12px 25px;
    border-radius: 8px;
    cursor: pointer;
    margin-top: 20px;
    transition: all 0.3s ease;
}

.regresar:hover {
    background: #d81b60; /* rosa más oscuro al pasar el mouse */
}

/* RESPONSIVE */
@media(max-width:600px){
    .dato {
        flex-direction: column;
        align-items: flex-start;
    }

    .botones {
        text-align: center;
    }

    .guardar, .regresar {
        width: 100%;
    }
}
</style>
</head>

<body>

<header>
    <div class="user-box">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png" alt="Usuario">
        <span id="nombreUsuario"><?php echo htmlspecialchars($usuario); ?></span>
    </div>
    <div class="titulo-header">Editar Perfil</div>
</header>

<div class="container">
    <div class="card">

        <input type="hidden" id="id" value="<?php echo $datos['id']; ?>">

        <div class="dato">
            <div class="etiqueta">Usuario:</div>
            <input type="text" id="usuario" value="<?php echo htmlspecialchars($datos['usuario']); ?>">
        </div>

        <div class="dato">
            <div class="etiqueta">Apellido:</div>
            <input type="text" id="apellido" value="<?php echo htmlspecialchars($datos['apellido']); ?>">
        </div>

        <div class="dato">
            <div class="etiqueta">Correo:</div>
            <input type="email" id="correo" value="<?php echo htmlspecialchars($datos['correo']); ?>">
        </div>

        <div class="dato">
            <div class="etiqueta">Teléfono:</div>
            <input type="text" id="telefono" value="<?php echo htmlspecialchars($datos['telefono']); ?>">
        </div>

        <div class="dato">
            <div class="etiqueta">CURP:</div>
            <input type="text" id="curp" value="<?php echo htmlspecialchars($datos['curp']); ?>">
        </div>

        <div class="dato">
            <div class="etiqueta">Nueva contraseña:</div>
            <input type="password" id="contrasena" placeholder="Dejar en blanco si no cambia">
        </div>

        <div class="botones">
            <button class="guardar" onclick="guardar()">Guardar Cambios</button>
        </div>

    </div>

    <div style="text-align:center;">
        <button class="regresar" onclick="window.location.href='realizar.html'">Regresar</button>
    </div>
</div>

<script>
function guardar(){
    const datos = {
        id: document.getElementById("id").value,
        usuario: document.getElementById("usuario").value,
        apellido: document.getElementById("apellido").value,
        correo: document.getElementById("correo").value,
        telefono: document.getElementById("telefono").value,
        curp: document.getElementById("curp").value,
        contrasena: document.getElementById("contrasena").value
    };

    fetch("perfil_usuario.php",{
        method:"POST",
        headers:{ "Content-Type":"application/json" },
        body: JSON.stringify(datos)
    })
    .then(res=>res.json())
    .then(res=>{
        if(res.success){
            alert("Datos actualizados ✅");
            if(res.logout){
                window.location.href="index.html";
            }
        }else{
            alert("Error: "+res.error);
        }
    })
    .catch(err=>alert("Error: "+err));
}
</script>

</body>
</html>