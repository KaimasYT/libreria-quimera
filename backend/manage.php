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
    <style>
        .libro {
            display: flex;
            align-items: center;
            border: 1px solid #ccc;
            padding: 10px;
            margin: 10px;
        }
        .libro img {
            width: 10%;
            height: auto;
            margin-right: 10px;
        }
        .libro .titulo {
            flex-grow: 1;
            font-size: 24px; /* Ajusta el tamaño del título */
        }
        .libro .eliminar {
            background-color: #f44336;
            color: white;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <h2>Gestionar mis libros</h2>
    <p>Bienvenido, <?= htmlspecialchars($_SESSION["nombre"]) ?> | <a href="libros.php">Ver biblioteca</a> | <a href="logout.php">Cerrar sesión</a></p>
    <p><?= $mensaje ?></p>

    <?php foreach ($libros as $libro): ?>
        <div class="libro">
            <img src="<?= htmlspecialchars($libro["imagen"] ?: 'images/default.png') ?>" alt="Imagen del libro">
            <div class="titulo"><?= htmlspecialchars($libro["titulo"]) ?></div>
            <form method="post" style="margin: 0;">
                <input type="hidden" name="libro_id" value="<?= $libro["id"] ?>">
                <button type="submit" class="eliminar">Eliminar</button>
            </form>
        </div>
    <?php endforeach; ?>
</body>
</html>
