<?php
require 'config.php';
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

if (!isset($_GET["id"])) {
    echo "ID de libro no proporcionado.";
    exit;
}

$id = intval($_GET["id"]);

$stmt = $pdo->prepare("SELECT titulo, contenido FROM libros WHERE id = ?");
$stmt->execute([$id]);
$libro = $stmt->fetch();

if (!$libro) {
    echo "Libro no encontrado.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title><?= htmlspecialchars($libro["titulo"]) ?> - Lectura</title>
    <link rel="stylesheet" href="css/lectura.css">
</head>
<body>
    <header>
        <h1><?= htmlspecialchars($libro["titulo"]) ?></h1>
        <nav>
            <a href="libros.php">← Volver a la biblioteca</a>
        </nav>
    </header>
    <div class="container">
        <div class="book-content">
            <p><?= htmlspecialchars(trim(preg_replace('/\s+/', ' ', $libro["contenido"]))) ?></p>
        </div>
    </div>
</body>
</html>
