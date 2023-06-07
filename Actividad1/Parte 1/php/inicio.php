<?php
session_start();

// Verificar si el usuario ha iniciado sesión
if (!isset($_SESSION['username'])) {
    header("Location: login.php"); // Redirigir al usuario al formulario de inicio de sesión si no ha iniciado sesión
    exit();
}

// Obtener el nombre de usuario de la sesión
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Bienvenido <?php echo $username; ?></title>
</head>
<body>
    <h2>Bienvenido, <?php echo $username; ?>!</h2>
    <p>Has iniciado sesión correctamente.</p>
    <a href="logout.php">Cerrar sesión</a>
</body>
</html>
