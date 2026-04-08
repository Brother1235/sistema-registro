<?php
require_once "conexion.php";

/* buscar datos */
$sql = "SELECT mensaje, telefono FROM atencion_telefonica WHERE id = 1";
$result = $conn->query($sql);

$mensaje = "Mensaje no disponible.";
$telefono = "Número no disponible.";

if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();
    $mensaje = $row["mensaje"];
    $telefono = $row["telefono"];
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Atención Telefónica</title>

<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

<style>

*{
margin:0;
padding:0;
box-sizing:border-box;
font-family:'Poppins', sans-serif;
}

/* 🔥 FONDO MORADO */
body{
min-height:100vh;
display:flex;
flex-direction:column;
background:linear-gradient(135deg,#4a148c,#7b1fa2);
}

/* 🔥 HEADER */
header{
background:#4a148c;
color:#90ee90; /* 🔥 VERDE CLARO */
padding:15px 25px;
text-align:center;
font-size:clamp(18px,4vw,26px);
font-weight:bold;
box-shadow:0 4px 10px rgba(0,0,0,0.2);
}

/* CONTENEDOR */
.container{
flex:1;
display:flex;
justify-content:center;
align-items:center;
padding:20px;
}

/* 🔥 TARJETA GRIS */
.card{
background:#e0e0e0;
padding:clamp(25px,5vw,50px);
border-radius:18px;
text-align:center;
box-shadow:0 6px 18px rgba(0,0,0,0.2);
width:100%;
max-width:520px;
transition:0.3s;
}

.card:hover{
transform:translateY(-5px);
box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

/* TITULO */
.card h2{
font-size:clamp(20px,5vw,28px);
color:#4a148c;
margin-bottom:15px;
}

/* MENSAJE */
.mensaje{
font-size:clamp(14px,3.5vw,16px);
color:#333;
margin-bottom:20px;
line-height:1.6;
}

/* AVISO */
.aviso{
background:#f3e5f5;
border:1px solid #d1a3e0;
color:#4a148c;
padding:12px;
border-radius:10px;
margin-top:10px;
font-size:clamp(13px,3vw,14px);
}

/* NUMERO */
.numero{
font-size:clamp(28px,8vw,48px);
font-weight:700;
color:#9c27b0;
letter-spacing:2px;
margin:25px 0;
word-break:break-word;
}

/* BOTON */
.btn-regresar{
background:#9c27b0;
color:white;
border:none;
padding:12px 28px;
font-size:clamp(14px,3.5vw,16px);
border-radius:30px;
cursor:pointer;
transition:0.3s;
}

.btn-regresar:hover{
background:#7b1fa2;
transform:scale(1.05);
}

/* 🔥 RESPONSIVE */
@media (max-width:480px){

.card{
padding:20px;
}

}

</style>

</head>

<body>

<header>
Centro de Atención Telefónica
</header>

<div class="container">

<div class="card">

<h2>📞 Atención Telefónica</h2>

<p class="mensaje">
<?php echo htmlspecialchars($mensaje); ?>
</p>

<div class="aviso">
Para recibir asistencia inmediata, comuníquese al número de atención que aparece a continuación.
</div>

<div class="numero">
<?php echo htmlspecialchars($telefono); ?>
</div>

<button class="btn-regresar" onclick="window.location.href='realizar.html'">
Regresar
</button>

</div>

</div>

</body>
</html>