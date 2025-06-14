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

// Procesar comentario si se envió el formulario
if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST["comentario"])) {
    $contenido = trim($_POST["comentario"]);
    $libro_id = intval($_GET["id"] ?? 0);

    if ($libro_id > 0 && $contenido !== '') {
        $stmt = $pdo->prepare("INSERT INTO comentarios (libro_id, usuario_id, contenido, fecha) VALUES (?, ?, ?, NOW())");
        $stmt->execute([$libro_id, $_SESSION["usuario_id"], $contenido]);
        header("Location: leer.php?id=" . $libro_id); // Redirige para evitar reenvío al recargar
        exit;
    }
}

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
<center><div>
    <h3>Comentarios</h3>
    <!-- Formulario para agregar comentario -->
    <form method="post" class="form-comentario" action="leer.php?id=<?= $id ?>">
        <label for="comentario">Añadir un comentario:</label><br>
        <textarea name="comentario" rows="4" cols="50" required></textarea><br>
        <button type="submit">Comentar</button>
    </form>
    <?php
    // Mostrar comentarios existentes
    $stmt = $pdo->prepare("SELECT comentarios.contenido, comentarios.fecha, usuarios.nombre
                           FROM comentarios
                           JOIN usuarios ON comentarios.usuario_id = usuarios.id
                           WHERE comentarios.libro_id = ?
                           ORDER BY comentarios.fecha DESC");
    $stmt->execute([$id]);
    $comentarios = $stmt->fetchAll();

    foreach ($comentarios as $comentario):
        ?>
        <div class="comentario">
            <strong><?= htmlspecialchars($comentario["nombre"]) ?></strong>
            <em>(<?= $comentario["fecha"] ?>)</em><br>
            <p><?= nl2br(htmlspecialchars($comentario["contenido"])) ?></p>
        </div>
    <?php endforeach; ?>
</div></center>
</body>
</html>