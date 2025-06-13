<?php
require 'config.php';

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST["nombre"] ?? '';
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    if (!empty($nombre) && !empty($email) && !empty($password)) {
        $hash = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO usuarios (nombre, email, password) VALUES (?, ?, ?)");
        try {
            $stmt->execute([$nombre, $email, $hash]);
            $mensaje = "Usuario registrado correctamente. <a href='login.php'>Iniciar sesión</a>";
        } catch (PDOException $e) {
            $mensaje = "Error: " . $e->getMessage();
        }
    } else {
        $mensaje = "Por favor, completa todos los campos.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Registro - Librería Químera</title>
    <link rel="stylesheet" href="css/style.css">

</head>
<body>
    <!-- Logo en la esquina superior izquierda -->
    <a href="index.php" style="position: absolute; top: 10px; left: 10px;">
        <img src="images/logoquimera.png" alt="Logo de Librería Químera" style="height: 100px;">
    </a>

    <header>
        <h1>Librería Químera</h1>
        <nav>
            <a href="register.php">Registrarse</a>
            <a href="login.php">Iniciar sesión</a>
            <a href="libros.php">Ver libros</a>
        </nav>
    </header>

    <h2>Registro de usuario</h2>

    <form method="post" class="form-login">
        <label for="nombre">Nombre:</label>
        <input type="text" name="nombre" id="nombre"><br><br>

        <label for="email">Correo:</label>
        <input type="email" name="email" id="email"><br><br>

        <label for="password">Contraseña:</label>
        <input type="password" name="password" id="password"><br><br>

        <input type="submit" value="Registrarse">
    </form>

    <p style="text-align: center; margin-top: 10px;"><?= $mensaje ?></p>
</body>
</html>