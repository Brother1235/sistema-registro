<?php
/* CARPETA DONDE SE GUARDARÁ LA IMAGEN */
$carpeta = "imagenes2/";

/* CREAR CARPETA SI NO EXISTE */
if (!file_exists($carpeta)) {
    mkdir($carpeta, 0777, true);
}

$mensaje = "";
$exito = false;

/* SUBIR UNA SOLA IMAGEN */
if (isset($_FILES['imagen'])) {
    $archivo = $_FILES['imagen'];

    if ($archivo['error'] === 0) {
        $tipo = mime_content_type($archivo['tmp_name']);
        $permitidos = ['image/jpeg', 'image/png', 'image/gif'];

        if (in_array($tipo, $permitidos)) {
            $ruta = $carpeta . "imagen.jpg"; // Siempre se guarda con este nombre
            if (move_uploaded_file($archivo['tmp_name'], $ruta)) {
                $mensaje = "✔ Imagen subida correctamente";
                $exito = true;
            } else {
                $mensaje = "❌ Error al mover el archivo";
            }
        } else {
            $mensaje = "❌ Solo se permiten imágenes (jpg, png, gif)";
        }
    } else {
        $mensaje = "❌ Ocurrió un error al subir la imagen";
    }
} else {
    $mensaje = "❌ No se seleccionó ninguna imagen";
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Resultado Subida</title>
<style>
body{
    font-family: Arial;
    background: #f0f2f5;
    text-align: center;
    padding-top: 80px;
}
.mensaje{
    background: white;
    width: 400px;
    margin: auto;
    padding: 40px;
    border-radius: 10px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.2);
}
h2{
    color: #6d1830;
}
button{
    background: #b28b42;
    border: none;
    padding: 10px 20px;
    color: white;
    cursor: pointer;
    border-radius: 6px;
    margin-top: 20px;
}
button:hover{
    background: #8c6d33;
}
</style>
</head>
<body>

<div class="mensaje">
<h2><?php echo $mensaje; ?></h2>
<?php if ($exito): ?>
<p>La imagen del sistema fue actualizada.</p>
<?php endif; ?>
<button onclick="window.location.href='subir-unica.html'">Regresar</button>
</div>

</body>
</html>