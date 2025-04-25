<?php
require 'config.php';

$stmt = $pdo->query("SELECT libros.titulo, libros.contenido, usuarios.nombre 
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
</head>
<body>
    <h2>Biblioteca</h2>
    <?php foreach ($libros as $libro): ?>
        <div style="border:1px solid #ccc; padding:10px; margin:10px;">
            <strong><?= htmlspecialchars($libro["titulo"]) ?></strong><br>
            <em>Subido por <?= htmlspecialchars($libro["nombre"]) ?></em><br><br>
            <pre><?= htmlspecialchars($libro["contenido"]) ?></pre>
        </div>
    <?php endforeach; ?>
</body>
</html>
