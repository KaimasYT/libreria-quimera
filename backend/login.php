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
        header("Location: upload.php");
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
</head>
<body>
    <h2>Iniciar sesión</h2>
    <form method="post">
        Correo: <input type="email" name="email"><br><br>
        Contraseña: <input type="password" name="password"><br><br>
        <input type="submit" value="Entrar">
    </form>
    <p><?= $mensaje ?></p>
</body>
</html>
