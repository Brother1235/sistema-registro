<?php
session_start();
require_once "conexion.php"; 

if(!isset($_SESSION['usuario'])) {
    echo "<p>No hay sesión iniciada. <a href='login.php'>Iniciar sesión</a></p>";
    exit();
}

$usuarioRegistro = $_SESSION['usuario'];

$sql = "SELECT * FROM beneficiarios WHERE usuario_registro = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $usuarioRegistro);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Beneficiarios</title>

<style>

/* RESET */
*{
    margin:0;
    padding:0;
    box-sizing:border-box;
}

/* FONDO */
body{
    font-family: Arial, Helvetica, sans-serif;
    background: #f3f3f3;
    min-height:100vh;
}

/* HEADER */
header{
    background: #4a148c;
    color: white;
    padding: 12px 25px;
    display:flex;
    justify-content:space-between;
    align-items:center;
    flex-wrap:wrap;
    box-shadow:0 2px 8px rgba(0,0,0,0.2);
}

/* USUARIO */
.user-box{
    display:flex;
    align-items:center;
    gap:10px;
}

.user-box img{
    width:40px;
    height:40px;
    border-radius:50%;
}

#nombreUsuario{
    font-size:14px;
    font-weight:bold;
}

/* TITULO */
.titulo-header{
    font-size:18px;
    font-weight:bold;
    text-align:center;
    width:100%;
}

/* CONTENEDOR */
.container{
    width:90%;
    max-width:1000px;
    margin:25px auto;
}

/* TARJETAS */
.card{
    background:#6a1b9a;
    color:white;
    padding:25px;
    margin-bottom:25px;
    border-radius:16px;
    box-shadow:0 6px 15px rgba(0,0,0,0.2);
    display:grid;
    grid-template-columns:1fr 180px;
    gap:20px;
    transition:0.3s;
}

.card:hover{
    transform:translateY(-5px);
    box-shadow:0 12px 25px rgba(0,0,0,0.3);
}

/* CAMPOS */
.fields{
    display:flex;
    flex-direction:column;
    gap:10px;
}

.card label{
    font-weight:bold;
    color:white;
    font-size:14px;
}

/* INPUTS */
.card input{
    padding:10px;
    font-size:14px;
    border-radius:8px;
    border:1px solid #bbb;
    background:#f3e5f5;
    color:#333;
    transition:0.3s;
}

.card input:focus{
    border-color:#9c27b0;
    outline:none;
    box-shadow:0 0 6px rgba(156,39,176,0.4);
    background:white;
}

/* BOTONES */
.buttons{
    display:flex;
    flex-direction:column;
    gap:10px;
    justify-content:center;
}

.card button{
    padding:12px;
    font-size:14px;
    cursor:pointer;
    border-radius:10px;
    border:none;
    color:white;
    font-weight:bold;
    transition:0.3s;
}

button.edit{
    background: linear-gradient(135deg, #9c27b0, #6a1b9a);
}
button.save{
    background: linear-gradient(135deg, #27ae60, #1e8449);
}
button.back{
    background: linear-gradient(135deg, #d32f2f, #9a0e0e);
}

button.edit:hover{
    background: linear-gradient(135deg, #7b1fa2, #4a148c);
}
button.save:hover{
    background: linear-gradient(135deg, #1e8449, #145a32);
}
button.back:hover{
    background: linear-gradient(135deg, #9a0e0e, #6d0a0a);
}

/* MENSAJE */
p{
    text-align:center;
    color:black;
    font-size:18px;
}

/* RESPONSIVE */
@media (max-width:768px){

    header{
        flex-direction:column;
        align-items:flex-start;
    }

    .titulo-header{
        text-align:center;
        width:100%;
        margin-top:5px;
    }

    .card{
        grid-template-columns:1fr;
    }

    .buttons{
        flex-direction:row;
        gap:5px;
    }

    .card button{
        flex:1;
        font-size:13px;
        padding:10px;
    }

}

</style>
</head>

<body>

<header>
    <div class="user-box">
        <img src="https://cdn-icons-png.flaticon.com/512/149/149071.png">
        <span id="nombreUsuario"><?php echo htmlspecialchars($usuarioRegistro); ?></span>
    </div>
    <div class="titulo-header">
        Beneficiarios
    </div>
</header>

<div class="container">

<?php if($result->num_rows > 0): ?>

<?php while($row = $result->fetch_assoc()): ?>

<div class="card" data-id="<?php echo $row['id']; ?>">

    <div class="fields">

        <label>Apellido Paterno</label>
        <input type="text" name="apellido_paterno" value="<?php echo htmlspecialchars($row['apellido_paterno']); ?>" disabled>

        <label>Apellido Materno</label>
        <input type="text" name="apellido_materno" value="<?php echo htmlspecialchars($row['apellido_materno']); ?>" disabled>

        <label>Nombre</label>
        <input type="text" name="nombre" value="<?php echo htmlspecialchars($row['nombre']); ?>" disabled>

        <label>Fecha Nacimiento</label>
        <input type="date" name="fecha_nacimiento" value="<?php echo htmlspecialchars($row['fecha_nacimiento']); ?>" disabled>

        <label>CURP</label>
        <input type="text" name="curp" value="<?php echo htmlspecialchars($row['curp']); ?>" disabled>

        <label>Teléfono</label>
        <input type="text" name="telefono" value="<?php echo htmlspecialchars($row['telefono']); ?>" disabled>

        <label>Domicilio</label>
        <input type="text" name="domicilio" value="<?php echo htmlspecialchars($row['domicilio']); ?>" disabled>

        <label>Localidad</label>
        <input type="text" name="localidad" value="<?php echo htmlspecialchars($row['localidad']); ?>" disabled>

        <label>Municipio</label>
        <input type="text" name="municipio" value="<?php echo htmlspecialchars($row['municipio']); ?>" disabled>

        <label>Responsable</label>
        <input type="text" name="nombre_responsable" value="<?php echo htmlspecialchars($row['nombre_responsable']); ?>" disabled>

        <label>Tel. Responsable</label>
        <input type="text" name="telefono_responsable" value="<?php echo htmlspecialchars($row['telefono_responsable']); ?>" disabled>

        <label>Sexo</label>
        <input type="text" name="sexo" value="<?php echo htmlspecialchars($row['sexo']); ?>" disabled>

        <label>Edad</label>
        <input type="number" name="edad" value="<?php echo htmlspecialchars($row['edad']); ?>" disabled>

        <label>Diagnóstico</label>
        <input type="text" name="diagnostico" value="<?php echo htmlspecialchars($row['diagnostico']); ?>" disabled>

        <label>Origen</label>
        <input type="text" name="origen" value="<?php echo htmlspecialchars($row['origen']); ?>" disabled>

    </div>

    <div class="buttons">
        <button class="edit">Editar</button>
        <button class="save">Guardar</button>
        <button class="back">Regresar</button>
    </div>

</div>

<?php endwhile; ?>

<?php else: ?>

<p>No se encontraron beneficiarios registrados.</p>

<?php endif; ?>

</div>

<script>
document.querySelectorAll('.card').forEach(card => {

    const editBtn = card.querySelector('.edit');
    const saveBtn = card.querySelector('.save');
    const backBtn = card.querySelector('.back');
    const inputs = card.querySelectorAll('input');

    editBtn.addEventListener('click', () => {
        inputs.forEach(i => i.disabled = false);
    });

    saveBtn.addEventListener('click', () => {

        const id = card.getAttribute('data-id');
        const data = {};

        inputs.forEach(i => data[i.name] = i.value);

        fetch('actualizar_beneficiario1.php',{
            method:'POST',
            headers:{ 'Content-Type':'application/json' },
            body:JSON.stringify({ id, ...data })
        })
        .then(res=>res.json())
        .then(res=>{
            if(res.success){
                alert('Datos actualizados ✅');
                inputs.forEach(i => i.disabled = true);
            }else{
                alert('Error al actualizar ❌');
            }
        })
        .catch(err=>alert('Error: '+err));

    });

    backBtn.addEventListener('click', () => {
        window.location.href='realizar.html';
    });

});
</script>

</body>
</html>

<?php
$stmt->close();
$conn->close();
?>