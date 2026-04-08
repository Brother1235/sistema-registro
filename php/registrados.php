<?php
define('ACCESO_PERMITIDO', true);
require_once "C:/wamp64/config_privado/config.php";

$conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
$conn->set_charset("utf8mb4");

$accion = $_GET['accion'] ?? '';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

/* ==============================
   🔴 ELIMINAR USUARIO
============================== */
if($accion === 'eliminar' && $id > 0){
    $stmt = $conn->prepare("DELETE FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    header("Location: registrados.php");
    exit();
}

/* ==============================
   🟢 ACTUALIZAR USUARIO
============================== */
if(isset($_POST['actualizar'])){
    $id = intval($_POST['id']);
    $usuario = $_POST['usuario'];
    $apellido = $_POST['apellido'];
    $correo = $_POST['correo'];
    $telefono = $_POST['telefono'];

    $update = $conn->prepare("UPDATE usuarios SET usuario=?, apellido=?, correo=?, telefono=? WHERE id=?");
    $update->bind_param("ssssi", $usuario, $apellido, $correo, $telefono, $id);
    $update->execute();

    header("Location: registrados.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Administración de Usuarios</title>

<style>
body{
    font-family:Arial;
    background:#f4f6f9;
    padding:20px;
}

h2{
    text-align:center;
}

table{
    width:100%;
    border-collapse:collapse;
    background:white;
}

th,td{
    padding:10px;
    border:1px solid #ddd;
    text-align:center;
}

th{
    background:#4CAF50;
    color:white;
}

.btn{
    padding:6px 12px;
    border:none;
    border-radius:5px;
    cursor:pointer;
    color:white;
}

.editar{ background:#2196F3;}
.editar:hover{ background:#1976D2;}

.eliminar{ background:#f44336;}
.eliminar:hover{ background:#d32f2f;}

.cancelar{ background:#9e9e9e;}
.cancelar:hover{ background:#757575;}

form{
    background:white;
    padding:20px;
    width:400px;
    margin:20px auto;
    border-radius:10px;
    box-shadow:0 2px 10px rgba(0,0,0,0.1);
}

input{
    width:100%;
    padding:8px;
    margin-bottom:10px;
}
</style>
</head>
<body>

<h2>Administración de Usuarios</h2>

<?php
/* ==============================
   ✏️ FORMULARIO DE EDICIÓN
============================== */
if($accion === 'editar' && $id > 0){

    $stmt = $conn->prepare("SELECT usuario, apellido, correo, telefono FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $usuario = $result->fetch_assoc();
?>

<form method="POST">
<input type="hidden" name="id" value="<?= $id ?>">

<input type="text" name="usuario" value="<?= $usuario['usuario'] ?>" required>
<input type="text" name="apellido" value="<?= $usuario['apellido'] ?>" required>
<input type="email" name="correo" value="<?= $usuario['correo'] ?>" required>
<input type="text" name="telefono" value="<?= $usuario['telefono'] ?>" required>

<div style="display:flex; gap:10px; justify-content:center;">
<button class="btn editar" type="submit" name="actualizar">
Guardar Cambios
</button>

<a href="registrados.php">
<button type="button" class="btn cancelar">
Cancelar
</button>
</a>
</div>

</form>

<hr>

<?php
}
?>

<table>
<tr>
<th>ID</th>
<th>Ficha</th>
<th>Cargo</th>
<th>Usuario</th>
<th>Apellido</th>
<th>Correo</th>
<th>Teléfono</th>
<th>CURP</th>
<th>Fecha</th>
<th>Acciones</th>
</tr>

<?php
$sql = "SELECT * FROM usuarios";
$resultado = $conn->query($sql);

while($fila = $resultado->fetch_assoc()){
echo "<tr>
<td>{$fila['id']}</td>
<td>{$fila['ficha']}</td>
<td>{$fila['cargo']}</td>
<td>{$fila['usuario']}</td>
<td>{$fila['apellido']}</td>
<td>{$fila['correo']}</td>
<td>{$fila['telefono']}</td>
<td>{$fila['curp']}</td>
<td>{$fila['fecha_registro']}</td>
<td>
<a href='registrados.php?accion=editar&id={$fila['id']}'>
<button class='btn editar'>Editar</button>
</a>

<a href='registrados.php?accion=eliminar&id={$fila['id']}'
onclick=\"return confirm('¿Seguro que deseas eliminar este usuario?');\">
<button class='btn eliminar'>Eliminar</button>
</a>
</td>
</tr>";
}
?>

</table>

</body>
</html>

<?php
$conn->close();
?>