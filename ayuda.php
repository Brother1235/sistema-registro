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

<style>
/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
    font-family: Arial, Helvetica, sans-serif;
}

/* FONDO MORADO */
body{
    min-height:100vh;
    display:flex;
    flex-direction:column;
    background:#4a148c; /* igual que Subir Imagen */
}

/* HEADER */
header{
    background:#9c27b0; /* morado intenso */
    color:white;
    padding:15px 25px;
    display:flex;
    justify-content:center;
    align-items:center;
}

header h1{
    font-size:24px;
    font-weight:bold;
    text-align:center;
}

/* CONTENEDOR */
.container{
    flex:1;
    display:flex;
    justify-content:center;
    align-items:center;
    padding:20px;
}

/* TARJETA BLANCA */
.card{
    background:white; /* tarjeta blanca */
    color:#4a148c;
    padding:30px;
    border-radius:12px;
    text-align:center;
    box-shadow:0 5px 15px rgba(0,0,0,0.2);
    width:100%;
    max-width:500px;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-4px);
    box-shadow:0 10px 25px rgba(0,0,0,0.3);
}

/* TITULO */
.card h2{
    color:#4a148c;
    margin-bottom:20px;
}

/* MENSAJE */
.mensaje{
    font-size:16px;
    color:#333;
    margin-bottom:20px;
    line-height:1.6;
}

/* AVISO */
.aviso{
    background:#f3e5f5; /* lilac suave */
    border:1px solid #9c27b0;
    color:#4a148c;
    padding:12px;
    border-radius:8px;
    margin-bottom:20px;
    font-size:14px;
}

/* NUMERO */
.numero{
    font-size:28px;
    font-weight:bold;
    color:#ffeb3b; /* amarillo para destacar */
    margin:15px 0;
    word-break:break-word;
}

/* BOTON */
.btn-regresar{
    background:#9c27b0;
    color:white;
    border:none;
    padding:12px 28px;
    font-size:16px;
    border-radius:8px;
    cursor:pointer;
    transition:0.3s;
}

.btn-regresar:hover{
    background:#7b1fa2;
}

/* RESPONSIVE */
@media (max-width:480px){
    .card{
        padding:20px;
    }
    .numero{
        font-size:24px;
    }
    .mensaje, .aviso{
        font-size:14px;
    }
}
</style>

</head>
<body>

<header>
    <h1>Centro de Atención Telefónica</h1>
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