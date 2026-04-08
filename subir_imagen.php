<?php

/* CARPETA DONDE SE GUARDARÁN LAS IMÁGENES */

$carpeta = "imagenes1/";

/* CREAR CARPETA SI NO EXISTE */

if(!file_exists($carpeta)){
mkdir($carpeta,0777,true);
}

/* SUBIR IMAGEN 1 */

if(isset($_FILES['imagen1']) && $_FILES['imagen1']['error']==0){

$ruta1 = $carpeta."imagen1.jpg";

move_uploaded_file($_FILES['imagen1']['tmp_name'],$ruta1);

}

/* SUBIR IMAGEN 2 */

if(isset($_FILES['imagen2']) && $_FILES['imagen2']['error']==0){

$ruta2 = $carpeta."imagen2.jpg";

move_uploaded_file($_FILES['imagen2']['tmp_name'],$ruta2);

}

/* SUBIR IMAGEN 3 */

if(isset($_FILES['imagen3']) && $_FILES['imagen3']['error']==0){

$ruta3 = $carpeta."imagen3.jpg";

move_uploaded_file($_FILES['imagen3']['tmp_name'],$ruta3);

}

/* SUBIR IMAGEN 4 */

if(isset($_FILES['imagen4']) && $_FILES['imagen4']['error']==0){

$ruta4 = $carpeta."imagen4.jpg";

move_uploaded_file($_FILES['imagen4']['tmp_name'],$ruta4);

}

?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Imágenes Subidas</title>

<style>

body{
font-family:Arial;
background:#f0f2f5;
text-align:center;
padding-top:80px;
}

.mensaje{
background:white;
width:400px;
margin:auto;
padding:40px;
border-radius:10px;
box-shadow:0 3px 10px rgba(0,0,0,0.2);
}

h2{
color:#6d1830;
}

button{
background:#b28b42;
border:none;
padding:10px 20px;
color:white;
cursor:pointer;
border-radius:6px;
margin-top:20px;
}

button:hover{
background:#8c6d33;
}

</style>
</head>

<body>

<div class="mensaje">

<h2>✔ Imágenes subidas correctamente</h2>

<p>Las imágenes del carrusel fueron actualizadas.</p>

<button onclick="window.location.href='subir_imagenes.html'">
Regresar
</button>

</div>

</body>
</html>