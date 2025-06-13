<?php
require 'config.php';
session_start();

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';
    $password = $_POST["password"] ?? '';

    $stmt = $pdo->prepare("SELECT * FROM usuarios WHERE email = ?");
    $stmt->execute([$email]);
    $usuario = $stmt->fetch();

    if ($usuario && password_verify($password, $usuario["password"])) {
        $_SESSION["usuario_id"] = $usuario["id"];
        $_SESSION["nombre"] = $usuario["nombre"];
        header("Location: libros.php");
        exit;
    } else {
        $mensaje = "Credenciales incorrectas.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Login - Librería Químera</title>
    <link rel="stylesheet" href="css/style.css">

</head>

<body>
    <header>
        <a href="index.php" style="position: absolute; top: 10px; left: 10px;">
            <img src="images/logoquimera.png" alt="Logo de Librería Químera" style="height: 100px;">
        </a>
        <h1>Librería Químera</h1>
        <nav>
            <a href="register.php">Registrarse</a>
            <a href="login.php">Iniciar sesión</a>
            <a href="libros.php">Ver libros</a>
        </nav>
    </header>
    <h2>Iniciar sesión</h2>
    <form method="post" class="form-login">
    <label for="email">Correo:</label>
    <input type="email" name="email" id="email"><br><br>

    <label for="password">Contraseña:</label>
    <input type="password" name="password" id="password"><br><br>

    <input type="submit" value="Entrar">
</form>

    <p><?= $mensaje ?></p>
</body>

</html>