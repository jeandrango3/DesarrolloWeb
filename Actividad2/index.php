<?php
$host = "localhost";
$usuario = "root";
$contraseña = "";
$baseDeDatos = "EjemploDesarrolloWeb";

$conn = new mysqli($host, $usuario, $contraseña, $baseDeDatos);

if ($conn->connect_error) {
    die("Error al conectar con la base de datos: " . $conexion->connect_error);
}
// Función para obtener todos los contactos de la base de datos
function obtenerContactos($conn) {
    $sql = "SELECT * FROM contactos";
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $contactos = array();
        while ($row = $result->fetch_assoc()) {
            $contactos[] = $row;
        }
        return $contactos;
    } else {
        return array();
    }
}

// Función para agregar un nuevo contacto
function agregarContacto($conn, $nombre,$apellido,$direccion, $correo, $telefono) {
    $nombre = $conn->real_escape_string($nombre);
    $apellido = $conn->real_escape_string($apellido);
    $direccion = $conn->real_escape_string($direccion);
    $correo = $conn->real_escape_string($correo);
    $telefono = $conn->real_escape_string($telefono);
    
    $sql = "INSERT INTO contactos (nombre, apellido, direccion, correo, telefono) VALUES ('$nombre', '$apellido', '$direccion', '$correo', '$telefono')";
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Función para editar un contacto existente
function editarContacto($conn, $id, $nombre,$apellido,$direccion, $correo, $telefono) {
    $nombre = $conn->real_escape_string($nombre);
    $apellido = $conn->real_escape_string($apellido);
    $direccion = $conn->real_escape_string($direccion);
    $correo = $conn->real_escape_string($correo);
    $telefono = $conn->real_escape_string($telefono);
    $sql = "UPDATE contactos SET id='$id', nombre='$nombre',apellido='$apellido',direccion='$direccion', correo='$correo', telefono='$telefono' WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}

// Función para eliminar un contacto
function eliminarContacto($conn, $id) {
    $sql = "DELETE FROM contactos WHERE id=$id";
    
    if ($conn->query($sql) === TRUE) {
        return true;
    } else {
        return false;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["agregar"])) {
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $direccion = $_POST["direccion"];
        $correo = $_POST["correo"];
        $telefono = $_POST["telefono"];
        
        agregarContacto($conn, $nombre,$apellido,$direccion, $correo, $telefono);
    } elseif (isset($_POST["editar"])) {
        $id = $_POST["id"];
        $nombre = $_POST["nombre"];
        $apellido = $_POST["apellido"];
        $direccion = $_POST["direccion"];
        $correo = $_POST["correo"];
        $telefono = $_POST["telefono"];
        
        editarContacto($conn, $id, $nombre,$apellido,$direccion, $correo, $telefono);
    } elseif (isset($_POST["eliminar"])) {
        $id = $_POST["id"];
        
        eliminarContacto($conn, $id);
    }
}

$contactos = obtenerContactos($conn);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Lista de contactos</title>
</head>
<body>
    <h1>Lista de contactos</h1>

    <!-- Formulario de agregar/editar -->
    <?php $contactos = obtenerContactos($conn); ?>
    <h2>Agregar/Editar contacto</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
        <label for="id">ID:</label>
        <input type="number" name="id" value="<?php echo isset($id) ? $id : ''; ?>"><br>
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" value="<?php echo isset($nombre) ? $nombre : ''; ?>"><br>

        <label for="apellido">Apellido:</label>
        <input type="text" name="apellido" value="<?php echo isset($apellido) ? $apellido : ''; ?>"><br>
        <label for="direccion">Dirección:</label>
        <input type="text" name="direccion" value="<?php echo isset($direccion) ? $direccion : ''; ?>"><br>

        <label for="correo">Correo:</label>
        <input type="email" name="correo" value="<?php echo isset($correo) ? $correo : ''; ?>"><br>
        <label for="telefono">Teléfono:</label>
        <input type="text" name="telefono" value="<?php echo isset($telefono) ? $telefono : ''; ?>"><br>
        <?php if (isset($id)): ?>
            <input type="submit" name="editar" value="Accionar">
        <?php else: ?>
            <input type="submit" name="agregar" value="Accionar">
        <?php endif; ?>
    </form>

    <!-- Lista de contactos -->
    <h2>Contactos</h2>
    <table border=1 alingn="center">
        <tr>
            <th>ID</th>
            <th>Nombre</th>
            <th>Apellido</th>
            <th>Dirección</th>
            <th>Correo</th>
            <th>Teléfono</th>
            <th>Acciones</th>
        </tr>
        <?php foreach ($contactos as $contacto): ?>
            <tr>
                <td><?php echo $contacto["id"]; ?></td>
                <td><?php echo $contacto["nombre"]; ?></td>
                <td><?php echo $contacto["apellido"]; ?></td>
                <td><?php echo $contacto["direccion"]; ?></td>
                <td><?php echo $contacto["correo"]; ?></td>
                <td><?php echo $contacto["telefono"]; ?></td>
                <td>
                    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                        <input type="hidden" name="id" value="<?php echo $contacto["id"]; ?>">
                        <input type="submit" name="eliminar" value="Eliminar" onclick="return confirm('¿Estás seguro de eliminar este contacto?');">
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>

<?php
// Cerrar conexión a la
$conn->close();
?>






