<?php
session_start();
require_once "conexion.php"; 

if(!isset($_SESSION['usuario'])) {
    echo "<p>No hay sesión iniciada. <a href='login.php'>Iniciar sesión</a></p>";
    exit();
}

$usuarioRegistro = $_SESSION['usuario'];

/* GUARDAR CAMBIOS */
if($_SERVER["REQUEST_METHOD"] == "POST"){

    $mensaje = $_POST["mensaje"];
    $telefono = $_POST["telefono"];

    $sql = "SELECT id FROM atencion_telefonica WHERE id = 1";
    $result = $conn->query($sql);

    if($result->num_rows > 0){

        $stmt = $conn->prepare("UPDATE atencion_telefonica SET mensaje=?, telefono=? WHERE id=1");
        $stmt->bind_param("ss",$mensaje,$telefono);
        $stmt->execute();

    }else{

        $stmt = $conn->prepare("INSERT INTO atencion_telefonica (id,mensaje,telefono) VALUES (1,?,?)");
        $stmt->bind_param("ss",$mensaje,$telefono);
        $stmt->execute();

    }

    echo "<script>alert('Cambios guardados correctamente');</script>";
}

/* obtener datos actuales */
$sql = "SELECT mensaje, telefono FROM atencion_telefonica WHERE id=1";
$result = $conn->query($sql);

$mensaje = "";
$telefono = "";

if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $mensaje = $row["mensaje"];
    $telefono = $row["telefono"];
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Administrador</title>

<style>

/* GENERAL */
body{
margin:0;
font-family:'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
background:#4a148c; /* 🔥 igual que los otros */
}

/* HEADER (UNIFICADO) */
header{
background:#9c27b0;
padding:15px 25px;
display:flex;
justify-content:space-between;
align-items:center;
color:white;
}

/* TEXTO HEADER */
.user-text{
font-size:22px;
font-weight:bold;
}

/* ADMIN */
#nombreUsuario{
font-size:18px;
font-weight:bold;
background:white;
color:#4a148c;
padding:6px 12px;
border-radius:8px;
}

/* ICONO MENU */
.menu-icon{
cursor:pointer;
}

.menu-icon div{
width:25px;
height:3px;
background:white;
margin:5px;
}

/* MENU */
.menu-box{
display:none;
position:absolute;
top:60px;
right:20px;
background:white;
border-radius:10px;
box-shadow:0 5px 15px rgba(0,0,0,0.2);
padding:10px;
}

.menu-box button{
background:#6a1b9a;
border:none;
color:white;
padding:10px;
border-radius:6px;
cursor:pointer;
width:100%;
}

.menu-box button:hover{
background:#4a148c;
}

/* CONTENEDOR */
.container{
width:90%;
max-width:700px;
margin:40px auto;
}

/* TITULO */
h1{
text-align:center;
color:white;
margin-bottom:20px;
}

/* TARJETA */
.card{
background:white;
padding:30px;
border-radius:15px;
box-shadow:0 10px 25px rgba(0,0,0,0.2);
}

/* LABELS */
label{
font-weight:bold;
margin-top:15px;
display:block;
color:#4a148c;
}

/* INPUTS */
textarea,
input{
width:100%;
padding:12px;
margin-top:5px;
border:1px solid #ccc;
border-radius:8px;
outline:none;
transition:0.3s;
}

textarea:focus,
input:focus{
border:1px solid #9c27b0;
box-shadow:0 0 5px rgba(156,39,176,0.4);
}

/* BOTONES */
button{
margin-top:20px;
padding:12px;
border:none;
border-radius:20px;
cursor:pointer;
font-size:14px;
}

/* GUARDAR */
button[type="submit"]{
background:#6a1b9a;
color:white;
}

button[type="submit"]:hover{
background:#4a148c;
}

/* REGRESAR */
.back{
background:#9c27b0;
color:white;
margin-left:10px;
}

.back:hover{
background:#7b1fa2;
}

</style>
</head>

<body>

<header>

<div class="user-text">Sistema De Registro DIF</div>

<div style="display:flex; align-items:center; gap:10px;">
<div id="nombreUsuario">
Administrador: <?php echo htmlspecialchars($usuarioRegistro); ?>
</div>

<div class="menu-box" id="menuBox">
<button onclick="cerrarSesion()">Cerrar sesión</button>
</div>

</div>

</header>

<div class="container">

<h1>Atención Telefónica</h1>

<div class="card">

<form method="POST">

<label>Escribe el texto</label>
<textarea name="mensaje" rows="4"><?php echo htmlspecialchars($mensaje); ?></textarea>

<label>Reemplazar número de teléfono</label>
<input type="text" name="telefono" value="<?php echo htmlspecialchars($telefono); ?>">

<button type="submit">Guardar cambios</button>

<button type="button" class="back" onclick="window.location.href='administrador.html'">
Regresar
</button>

</form>

</div>

</div>

<script>

/* MENÚ */
function toggleMenu() {
const menu = document.getElementById('menuBox');
menu.style.display = menu.style.display === 'block' ? 'none' : 'block';
}

function cerrarSesion() {
window.location.href = 'logout.php';
}

</script>

</body>
</html>