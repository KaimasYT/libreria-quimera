<?php
require 'config.php';
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["libro_id"])) {
    $libro_id = $_POST["libro_id"];
    $stmt = $pdo->prepare("DELETE FROM libros WHERE id = ? AND usuario_id = ?");
    $stmt->execute([$libro_id, $_SESSION["usuario_id"]]);
    $mensaje = "Libro eliminado correctamente.";
}

$stmt = $pdo->prepare("SELECT id, titulo, imagen FROM libros WHERE usuario_id = ? ORDER BY fecha_subida DESC");
$stmt->execute([$_SESSION["usuario_id"]]);
$libros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestionar libros - Librería Químera</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <header class="header">
        <a href="index.php" class="logo-container">
            <img src="images/logoquimera.png" alt="Logo de la librería" class="logo">
        </a>
        <div class="titulo-container">
            <h1 class="titulo">Librería Químera</h1>
        </div>
        <div class="espacio-vacio"></div>
    </header>

    <nav class="nav-usuario">
        <p>
            Bienvenido, <?= htmlspecialchars($_SESSION["nombre"]) ?> |
            <a href="libros.php">Ver biblioteca</a> |
            <a href="logout.php">Cerrar sesión</a>
        </p>
    </nav>

    <main class="main-container">
        <h2>Gestionar mis libros</h2>
        <?php if ($mensaje): ?>
            <p class="mensaje-exito"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>

        <div class="lista-libros">
            <?php foreach ($libros as $libro): ?>
                <div class="libro">
                    <img src="<?= htmlspecialchars($libro["imagen"] ?: 'images/default.png') ?>" alt="Imagen del libro" class="libro-img">
                    <div class="titulo-libro"><?= htmlspecialchars($libro["titulo"]) ?></div>
                    <form method="post" class="form-eliminar">
                        <input type="hidden" name="libro_id" value="<?= $libro["id"] ?>">
                        <button type="submit" class="btn-eliminar">Eliminar</button>
                    </form>
                </div>
            <?php endforeach; ?>
        </div>
    </main>
</body>
</html>
