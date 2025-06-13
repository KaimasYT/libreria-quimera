<?php
require 'config.php';
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$stmt = $pdo->query("SELECT libros.id, libros.titulo, libros.contenido, libros.imagen, usuarios.nombre 
                     FROM libros 
                     JOIN usuarios ON libros.usuario_id = usuarios.id 
                     ORDER BY fecha_subida DESC");

$libros = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Biblioteca - Librería Químera</title>
    <link rel="stylesheet" href="css/libros.css">
</head>

<body>
<header class="header">
        <a href="index.php">
            <img src="images/logoquimera.png" alt="Logo de Librería Químera" style="height: 100px;">
        </a>
        <div class="titulo-container">
            <h1 class="titulo">Librería Químera</h1>
        </div>
        <div class="espacio-vacio"></div> <!-- zona vacía para equilibrar -->
    </header>


    <nav>
            <a href="upload.php">Subir libro</a>
            <a href="logout.php">Cerrar sesión</a>
            <a href="manage.php">Mis Libros</a>
        </nav>
    <div class="container">
        <h2>Biblioteca de libros</h2>
        <p class="user-info">
            Bienvenido, <?= htmlspecialchars($_SESSION["nombre"]) ?>
        </p>

        <div class="book-list">
            <?php foreach ($libros as $libro): ?>
                <div class="book">
                    <img src="<?= htmlspecialchars($libro["imagen"] ?: 'images/default.png') ?>" alt="Imagen del libro"
                        class="book-img">
                    <div class="book-info">
                        <div class="book-title"><?= htmlspecialchars($libro["titulo"]) ?></div>
                        <div class="book-author">Subido por <?= htmlspecialchars($libro["nombre"]) ?></div>
                        <?php
                        // Extraer las primeras 50 palabras del contenido
                        $palabras = explode(' ', strip_tags($libro["contenido"]));
                        $resumen = implode(' ', array_slice($palabras, 0, 50));
                        ?>
                        <p class="book-preview"><?= htmlspecialchars($resumen) ?>...</p>
                        <form action="leer.php" method="get">
                            <input type="hidden" name="id" value="<?= htmlspecialchars($libro["id"]) ?>">
                            <button type="submit" class="leer-btn">Leer</button>
                        </form>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</body>

</html>