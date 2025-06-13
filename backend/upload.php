<?php
require 'config.php';
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"] ?? '';
    $texto_manual = trim($_POST["texto_manual"] ?? '');
    $contenido = '';
    $imagen = 'images/default.png'; // Imagen por defecto

    if (!empty($texto_manual)) {
        $contenido = $texto_manual;
    } elseif (isset($_FILES["archivo"]) && $_FILES["archivo"]["error"] === 0) {
        $contenido = file_get_contents($_FILES["archivo"]["tmp_name"]);
    }

    if (isset($_FILES["imagen"]) && $_FILES["imagen"]["error"] === 0) {
        $upload_dir = 'images/ImagenesUpload/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }
        $imagen = $upload_dir . basename($_FILES["imagen"]["name"]);
        if (!move_uploaded_file($_FILES["imagen"]["tmp_name"], $imagen)) {
            $imagen = 'images/default.png';
            $mensaje = "Error al subir la imagen, se usará la imagen por defecto.";
        }
    }

    if (!empty($titulo) && !empty($contenido)) {
        $stmt = $pdo->prepare("INSERT INTO libros (titulo, contenido, usuario_id, imagen) VALUES (?, ?, ?, ?)");
        $stmt->execute([$titulo, $contenido, $_SESSION["usuario_id"], $imagen]);
        header("Location: libros.php");
        exit;
    } else {
        $mensaje = "Por favor, completa el título y el contenido (archivo o texto manual).";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir libro - Librería Químera</title>
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
        <p>Bienvenido, <?= htmlspecialchars($_SESSION["nombre"]) ?> | <a href="libros.php">Ver biblioteca</a> | <a href="logout.php">Cerrar sesión</a></p>
    </nav>

    <main class="main-container">
        <h2>Subir un nuevo libro</h2>
        <?php if ($mensaje): ?>
            <p class="mensaje-error"><?= htmlspecialchars($mensaje) ?></p>
        <?php endif; ?>
        <form method="post" enctype="multipart/form-data" class="form-subir-libro">
            <label for="titulo">Título:</label><br>
            <input type="text" id="titulo" name="titulo" required><br><br>

            <label for="archivo">Subir archivo (.txt):</label><br>
            <input type="file" id="archivo" name="archivo" accept=".txt"><br><br>

            <label for="texto_manual">O escribir contenido directamente:</label><br>
            <textarea id="texto_manual" name="texto_manual" rows="10" placeholder="Escribe aquí el contenido del libro..."></textarea><br><br>

            <label for="imagen">Subir imagen:</label><br>
            <input type="file" id="imagen" name="imagen" accept="image/*"><br><br>

            <input type="submit" value="Subir">
        </form>
    </main>
</body>
</html>
