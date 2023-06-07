<!DOCTYPE html>
<html>
<head>
    <title>Sistema de Login</title>
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="POST" action="php/login.php">
        <label for="username">Usuario:</label>
        <input type="text" name="username" required><br><br>
        
        <label for="password">Contraseña:</label>
        <input type="password" name="password" required><br><br>
        
        <input type="submit" value="Iniciar sesión">
    </form>
</body>
</html>