<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Librería Químera</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<?php
require 'config.php';

// Obtener la imagen del último libro subido
$stmt = $pdo->query("SELECT imagen FROM libros ORDER BY fecha_subida DESC LIMIT 1");
$imagen = $stmt->fetch(PDO::FETCH_ASSOC);
$imagenRuta = $imagen && !empty($imagen['imagen']) ? htmlspecialchars($imagen['imagen']) : 'images/default.png';
?>

<body>
    <header class="header">
        <div class="logo-container">
            <img src="images/logoquimera.png" alt="Logo de la librería" class="logo">
        </div>
        <div class="titulo-container">
            <h1 class="titulo">Librería Químera</h1>
        </div>
        <div class="espacio-vacio"></div> <!-- zona vacía para equilibrar -->
    </header>

    <nav style="text-align: center; margin-top: 10px;">
        <a href="register.php">Registrarse</a>
        <a href="login.php">Iniciar sesión</a>
        <a href="libros.php">Ver libros</a>
    </nav>

    <div class="container">
        <h1 class="title text-center">Bienvenido a Librería Químera</h1>
        <p class="text-center">Comparte y descubre libros de texto online</p>
        <h2 class="text-center">Último libro compartido</h2>
        <div class="destacada-img-wrapper text-center" style="margin: 20px 0;">
            <img src="<?= $imagenRuta ?>" alt="Último libro subido" class="destacada-img">
        </div>
    </div>

    <footer style="text-align: center; margin-top: 40px; padding: 20px; background-color: #f4f4f4;">
        <p>Síguenos en nuestras redes sociales:</p>
        <p>Facebook | Twitter | Instagram</p>
        <p>&copy; 2025 Librería Químera. Todos los derechos reservados.</p>
    </footer>
</body>

</html>