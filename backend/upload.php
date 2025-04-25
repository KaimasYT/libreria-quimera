<?php
require 'config.php';
session_start();

if (!isset($_SESSION["usuario_id"])) {
    header("Location: login.php");
    exit;
}

$mensaje = '';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_FILES["archivo"])) {
    $titulo = $_POST["titulo"] ?? '';
    $contenido = file_get_contents($_FILES["archivo"]["tmp_name"]);

    if (!empty($titulo) && !empty($contenido)) {
        $stmt = $pdo->prepare("INSERT INTO libros (titulo, contenido, usuario_id) VALUES (?, ?, ?)");
        $stmt->execute([$titulo, $contenido, $_SESSION["usuario_id"]]);
        $mensaje = "Libro subido correctamente.";
    } else {
        $mensaje = "Por favor, completa todos los campos y selecciona un archivo.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Subir libro - Librería Químera</title>
</head>
<body>
    <h2>Subir un nuevo libro</h2>
    <form method="post" enctype="multipart/form-data">
        Título: <input type="text" name="titulo"><br><br>
        Archivo (.txt): <input type="file" name="archivo" accept=".txt"><br><br>
        <input type="submit" value="Subir">
    </form>
    <p><?= $mensaje ?></p>
    <br>
    <a href="libros.php">Ver biblioteca</a>
</body>
</html>
