<?php
session_start();
session_destroy(); // Cerrar la sesión

header("Location: ../Tarea1.php"); // Redirigir al usuario al formulario de inicio de sesión
exit();
?>
